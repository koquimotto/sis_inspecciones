<?php

namespace App\Livewire\Empresas;

use App\Actions\Empresas\EmpresaAction;
use App\Models\Empresa;
use App\Models\Pais;
use App\Models\Region;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class Modal extends Component
{
    public bool $modal = false;
    public string $titleModal = 'Nueva Empresa';

    public ?int $editingId = null;
    public ?int $contacto_id = null;

    public array $state = [];
    public array $contacto = [];

    public array $paisOptions = [];
    public array $regionOptions = [];
    public array $unidadMineraOptions = [];

    public function mount(): void
    {
        $this->loadOptions();
        $this->resetState();
    }

    #[On('empresas-modal:open')]
    public function open(int $id = 0, string $title = 'Nueva Empresa'): void
    {
        $this->resetValidation();
        $this->loadOptions();
        $this->resetState();

        $this->titleModal = $title;
        $this->editingId = $id > 0 ? $id : null;
        $this->modal = true;

        if ($id <= 0) {
            return;
        }

        $empresa = app(EmpresaAction::class)->find($id);

        if (!$empresa) {
            $this->dispatch(
                'swal',
                type: 'error',
                title: 'No encontrado',
                text: 'No se pudo cargar la empresa seleccionada.'
            );
            return;
        }

        $this->state = array_merge($this->state, [
            'id'               => $empresa->id,
            'tipo'             => $empresa->tipo,
            'unidad_minera_id' => $empresa->unidad_minera_id,
            'ruc'              => $empresa->ruc,
            'razon_social'     => $empresa->razon_social,
            'nombre_comercial' => $empresa->nombre_comercial,
            'email'            => $empresa->email,
            'telefono'         => $empresa->telefono,
            'pais_id'          => $empresa->pais_id,
            'region_id'        => $empresa->region_id,
            'ciudad'           => $empresa->ciudad,
            'direccion'        => $empresa->direccion,
            'estado'           => (int) $empresa->estado,
        ]);

        $this->updatedStatePaisId($this->state['pais_id']);

        $contactoPivot = $empresa->contactos()
            ->with('persona')
            ->where('estado', 1)
            ->latest('id')
            ->first();

        if ($contactoPivot && $contactoPivot->persona) {
            $persona = $contactoPivot->persona;

            $this->contacto_id = $persona->id;

            $this->contacto = array_merge($this->contacto, [
                'id'                => $persona->id,
                'tipo_documento'    => $persona->tipo_documento,
                'numero_documento'  => $persona->numero_documento,
                'cargo'             => $persona->cargo,
                'nombres'           => $persona->nombres,
                'apellido_paterno'  => $persona->apellido_paterno,
                'apellido_materno'  => $persona->apellido_materno,
                'email'             => $persona->email,
                'telefono'          => $persona->telefono,
                'notas'             => $persona->notas,
                'estado'            => (int) $persona->estado,
            ]);
        }
    }

    public function updatedStatePaisId($value): void
    {
        $paisId = (int) $value;

        $this->regionOptions = Region::query()
            ->when($paisId > 0, fn ($q) => $q->where('pais_id', $paisId))
            ->where('estado', 1)
            ->orderBy('region')
            ->get()
            ->map(fn ($r) => [
                'id' => $r->id,
                'label' => $r->region,
            ])
            ->values()
            ->toArray();

        if (!collect($this->regionOptions)->pluck('id')->contains((int) $this->state['region_id'])) {
            $this->state['region_id'] = '';
        }
    }

    public function buscarContacto(EmpresaAction $action): void
    {
        $numeroDocumento = trim((string) ($this->contacto['numero_documento'] ?? ''));

        if ($numeroDocumento === '') {
            return;
        }

        $persona = $action->findPersonaByDocumento($numeroDocumento);

        if (!$persona) {
            $this->contacto_id = null;

            $this->dispatch(
                'swal',
                type: 'info',
                title: 'Contacto no encontrado',
                text: 'No existe una persona con ese documento. Puedes completar los datos y se creará al guardar.'
            );
            return;
        }

        $this->contacto_id = $persona->id;

        $this->contacto = array_merge($this->contacto, [
            'id'                => $persona->id,
            'tipo_documento'    => $persona->tipo_documento,
            'numero_documento'  => $persona->numero_documento,
            'cargo'             => $persona->cargo,
            'nombres'           => $persona->nombres,
            'apellido_paterno'  => $persona->apellido_paterno,
            'apellido_materno'  => $persona->apellido_materno,
            'email'             => $persona->email,
            'telefono'          => $persona->telefono,
            'notas'             => $persona->notas,
            'estado'            => (int) ($persona->estado ?? 1),
        ]);

        $nombre = trim($persona->nombres . ' ' . $persona->apellido_paterno . ' ' . $persona->apellido_materno);

        $this->dispatch(
            'swal',
            type: 'success',
            title: 'Contacto encontrado',
            text: "Se cargaron los datos de {$nombre}."
        );
    }

    public function save(EmpresaAction $action): void
    {
        try {
            $this->validate($this->rules(), [], $this->attributes());

            if ($this->editingId) {
                $empresa = $action->updateConContacto($this->editingId, $this->state, $this->contacto);
                $msg = "La empresa {$empresa->razon_social} fue actualizada correctamente.";
            } else {
                $empresa = $action->storeConContacto($this->state, $this->contacto);
                $msg = "La empresa {$empresa->razon_social} con RUC {$empresa->ruc} fue registrada correctamente.";
            }

            $this->modal = false;
            $this->dispatch('empresas:refresh');
            $this->dispatch(
                'swal',
                type: 'success',
                title: 'Proceso exitoso',
                text: $msg
            );

            $this->resetValidation();
            $this->resetState();
        } catch (ValidationException $e) {
            $firstMsg = collect($e->errors())->flatten()->first() ?? 'Revisa los campos obligatorios.';

            $this->dispatch(
                'swal',
                type: 'warning',
                title: 'Campos incompletos',
                text: $firstMsg
            );

            throw $e;
        } catch (\Throwable $e) {
            report($e);

            $this->dispatch(
                'swal',
                type: 'error',
                title: 'Error',
                text: $e->getMessage() ?: 'Ocurrió un problema al guardar.'
            );
        }
    }

    private function loadOptions(): void
    {
        $this->paisOptions = Pais::query()
            ->orderBy('pais')
            ->get()
            ->map(fn ($p) => [
                'id' => $p->id,
                'label' => $p->pais,
            ])
            ->values()
            ->toArray();

        $this->unidadMineraOptions = Empresa::query()
            ->where('estado', 1)
            ->where('tipo', 'UNIDAD_MINERA')
            ->orderBy('razon_social')
            ->get()
            ->map(fn ($e) => [
                'id' => $e->id,
                'label' => $e->razon_social,
            ])
            ->values()
            ->toArray();

        $this->regionOptions = [];
    }

    private function resetState(): void
    {
        $this->state = [
            'id'               => null,
            'tipo'             => 'empresa',
            'unidad_minera_id' => null,
            'ruc'              => '',
            'razon_social'     => '',
            'nombre_comercial' => '',
            'email'            => '',
            'telefono'         => '',
            'pais_id'          => '',
            'region_id'        => '',
            'ciudad'           => '',
            'direccion'        => '',
            'estado'           => 1,
        ];
    
        $this->contacto = [
            'id'                => null,
            'tipo_documento'    => 'DNI',
            'numero_documento'  => '',
            'cargo'             => '',
            'nombres'           => '',
            'apellido_paterno'  => '',
            'apellido_materno'  => '',
            'email'             => '',
            'telefono'          => '',
            'notas'             => '',
            'estado'            => 1,
        ];
    }

    protected function rules(): array
    {
        return [
            'state.tipo'             => ['required', Rule::in(['EMPRESA', 'UNIDAD_MINERA'])],
            'state.unidad_minera_id' => ['nullable', 'integer'],
            'state.ruc'              => ['required', 'digits:11'],
            'state.razon_social'     => ['required', 'string', 'max:200'],
            'state.nombre_comercial' => ['nullable', 'string', 'max:200'],
            'state.email'            => ['nullable', 'email', 'max:150'],
            'state.telefono'         => ['nullable', 'string', 'max:30'],
            'state.pais_id'          => ['required', 'integer'],
            'state.region_id'        => ['required', 'integer'],
            'state.ciudad'           => ['nullable', 'string', 'max:150'],
            'state.direccion'        => ['nullable', 'string', 'max:250'],
            'state.estado'           => ['required', 'boolean'],

            'contacto.tipo_documento'   => ['required', Rule::in(['DNI', 'CE', 'PAS'])],
            'contacto.numero_documento' => ['required', 'string', 'max:20'],
            'contacto.nombres'          => ['required', 'string', 'max:120'],
            'contacto.apellido_paterno' => ['required', 'string', 'max:120'],
            'contacto.apellido_materno' => ['required', 'string', 'max:120'],
            'contacto.cargo'            => ['nullable', 'string', 'max:120'],
            'contacto.email'            => ['nullable', 'email', 'max:150'],
            'contacto.telefono'         => ['nullable', 'string', 'max:30'],
            'contacto.notas'            => ['nullable', 'string'],
            'contacto.estado'           => ['required', 'boolean'],
        ];
    }

    protected function attributes(): array
    {
        return [
            'state.tipo'                 => 'tipo',
            'state.ruc'                  => 'RUC',
            'state.razon_social'         => 'razón social',
            'state.pais_id'              => 'país',
            'state.region_id'            => 'región',
            'contacto.tipo_documento'    => 'tipo de documento del contacto',
            'contacto.numero_documento'  => 'número de documento del contacto',
            'contacto.nombres'           => 'nombres del contacto',
            'contacto.apellido_paterno'  => 'apellido paterno del contacto',
            'contacto.apellido_materno'  => 'apellido materno del contacto',
        ];
    }

    public function render()
    {
        return view('livewire.empresas.modal');
    }
}