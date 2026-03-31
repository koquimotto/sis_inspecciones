<?php

namespace App\Livewire\Inspecciones;

use App\Models\Categoria;
use App\Models\CuestionarioCategoria;
use App\Models\CuestionarioPregunta;
use App\Models\CuestionarioSubCategoria;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Tipo;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CatalogosManager extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'tailwind';

    public string $searchCategoria = '';
    public string $searchSubCategoria = '';
    public string $searchPregunta = '';
    public int $perPagePreguntas = 15;

    public ?int $selectedCategoriaId = null;
    public ?int $selectedSubCategoriaId = null;

    public bool $categoriaModal = false;
    public bool $subCategoriaModal = false;
    public bool $preguntaModal = false;

    public ?int $editingCategoriaId = null;
    public ?int $editingSubCategoriaId = null;
    public ?int $editingPreguntaId = null;

    public array $categoriaForm = [];
    public array $subCategoriaForm = [];
    public array $preguntaForm = [];

    public array $preguntaTipoIds = [];
    public array $preguntaCategoriaIds = [];
    public array $preguntaMarcaIds = [];
    public array $preguntaModeloIds = [];

    public array $responseTypeOptions = [
        'select' => 'Select',
        'radio' => 'Radio',
        'entero' => 'Entero',
        'decimal' => 'Decimal',
        'texto' => 'Texto',
    ];

    public function mount(): void
    {
        $this->resetCategoriaForm();
        $this->resetSubCategoriaForm();
        $this->resetPreguntaForm();
    }

    public function seleccionarCategoria(?int $id = null): void
    {
        $this->selectedCategoriaId = $this->selectedCategoriaId === $id ? null : $id;
        $this->resetPage();
    }

    public function seleccionarSubCategoria(?int $id = null): void
    {
        $this->selectedSubCategoriaId = $this->selectedSubCategoriaId === $id ? null : $id;
        $this->resetPage();
    }

    public function limpiarFiltrosPregunta(): void
    {
        $this->selectedCategoriaId = null;
        $this->selectedSubCategoriaId = null;
        $this->searchPregunta = '';
        $this->resetPage();
    }

    public function updatingSearchCategoria(): void
    {
        $this->resetPage();
    }

    public function updatingSearchSubCategoria(): void
    {
        $this->resetPage();
    }

    public function updatingSearchPregunta(): void
    {
        $this->resetPage();
    }

    public function openCategoriaModal(int $id = 0): void
    {
        $this->resetValidation();
        $this->resetCategoriaForm();
        $this->editingCategoriaId = $id > 0 ? $id : null;
        $this->categoriaModal = true;

        if (!$this->editingCategoriaId) {
            return;
        }

        $categoria = CuestionarioCategoria::findOrFail($this->editingCategoriaId);

        $this->categoriaForm = [
            'descripcion' => $categoria->descripcion,
            'estado' => (int) $categoria->estado,
        ];
    }

    public function saveCategoria(): void
    {
        $data = $this->validate([
            'categoriaForm.descripcion' => ['required', 'string', 'max:120'],
            'categoriaForm.estado' => ['required', 'boolean'],
        ], [], [
            'categoriaForm.descripcion' => 'descripcion de categoria',
        ]);

        $categoria = $this->editingCategoriaId
            ? CuestionarioCategoria::findOrFail($this->editingCategoriaId)
            : new CuestionarioCategoria();

        $categoria->fill($data['categoriaForm']);
        $categoria->save();

        $this->categoriaModal = false;
        $this->resetCategoriaForm();
        $this->dispatch('swal', type: 'success', title: 'Categoria guardada', text: 'La categoria fue registrada correctamente.');
    }

    public function openSubCategoriaModal(int $id = 0): void
    {
        $this->resetValidation();
        $this->resetSubCategoriaForm();
        $this->editingSubCategoriaId = $id > 0 ? $id : null;
        $this->subCategoriaModal = true;

        if (!$this->editingSubCategoriaId) {
            return;
        }

        $subCategoria = CuestionarioSubCategoria::findOrFail($this->editingSubCategoriaId);

        $this->subCategoriaForm = [
            'descripcion' => $subCategoria->descripcion,
            'estado' => (int) $subCategoria->estado,
        ];
    }

    public function saveSubCategoria(): void
    {
        $data = $this->validate([
            'subCategoriaForm.descripcion' => ['required', 'string', 'max:255'],
            'subCategoriaForm.estado' => ['required', 'boolean'],
        ], [], [
            'subCategoriaForm.descripcion' => 'descripcion de subcategoria',
        ]);

        $subCategoria = $this->editingSubCategoriaId
            ? CuestionarioSubCategoria::findOrFail($this->editingSubCategoriaId)
            : new CuestionarioSubCategoria();

        $subCategoria->fill($data['subCategoriaForm']);
        $subCategoria->save();

        $this->subCategoriaModal = false;
        $this->resetSubCategoriaForm();
        $this->dispatch('swal', type: 'success', title: 'Subcategoria guardada', text: 'La subcategoria fue registrada correctamente.');
    }

    public function openPreguntaModal(int $id = 0): void
    {
        $this->resetValidation();
        $this->resetPreguntaForm();
        $this->editingPreguntaId = $id > 0 ? $id : null;
        $this->preguntaModal = true;

        if (!$this->editingPreguntaId) {
            if ($this->selectedCategoriaId) {
                $this->preguntaForm['cuestionario_categoria_id'] = $this->selectedCategoriaId;
            }

            if ($this->selectedSubCategoriaId) {
                $this->preguntaForm['cuestionario_sub_categoria_id'] = $this->selectedSubCategoriaId;
            }

            return;
        }

        $pregunta = CuestionarioPregunta::findOrFail($this->editingPreguntaId);

        $this->preguntaForm = [
            'cuestionario_categoria_id' => $pregunta->cuestionario_categoria_id,
            'cuestionario_sub_categoria_id' => $pregunta->cuestionario_sub_categoria_id,
            'pregunta_enunciado' => $pregunta->pregunta_enunciado,
            'ingeso_preguntar' => (int) $pregunta->ingeso_preguntar,
            'ingreso_respuesta_tipo' => $pregunta->ingreso_respuesta_tipo,
            'ingreso_respuesta_valores' => $pregunta->ingreso_respuesta_valores,
            'salida_preguntar' => (int) $pregunta->salida_preguntar,
            'salida_respuesta_tipo' => $pregunta->salida_respuesta_tipo,
            'salida_respuesta_valores' => $pregunta->salida_respuesta_valores,
            'permitir_observaciones' => (int) $pregunta->permitir_observaciones,
            'estado' => (int) $pregunta->estado,
        ];

        $this->preguntaTipoIds = $this->unpackIds($pregunta->equipo_tipo_ids);
        $this->preguntaCategoriaIds = $this->unpackIds($pregunta->equipo_categoria_ids);
        $this->preguntaMarcaIds = $this->unpackIds($pregunta->equipo_marca_ids);
        $this->preguntaModeloIds = $this->unpackIds($pregunta->equipo_modelo_ids);
    }

    public function savePregunta(): void
    {
        $data = $this->validate([
            'preguntaForm.cuestionario_categoria_id' => ['required', 'integer', Rule::exists('cuestionario_categorias', 'id')],
            'preguntaForm.cuestionario_sub_categoria_id' => ['required', 'integer', Rule::exists('cuestionario_sub_categorias', 'id')],
            'preguntaForm.pregunta_enunciado' => ['required', 'string', 'max:255'],
            'preguntaForm.ingeso_preguntar' => ['required', 'boolean'],
            'preguntaForm.ingreso_respuesta_tipo' => ['nullable', Rule::in(array_keys($this->responseTypeOptions))],
            'preguntaForm.ingreso_respuesta_valores' => ['nullable', 'string', 'max:255'],
            'preguntaForm.salida_preguntar' => ['required', 'boolean'],
            'preguntaForm.salida_respuesta_tipo' => ['nullable', Rule::in(array_keys($this->responseTypeOptions))],
            'preguntaForm.salida_respuesta_valores' => ['nullable', 'string', 'max:255'],
            'preguntaForm.permitir_observaciones' => ['required', 'boolean'],
            'preguntaForm.estado' => ['required', 'boolean'],
        ], [], [
            'preguntaForm.cuestionario_categoria_id' => 'categoria',
            'preguntaForm.cuestionario_sub_categoria_id' => 'subcategoria',
            'preguntaForm.pregunta_enunciado' => 'enunciado',
        ]);

        $pregunta = $this->editingPreguntaId
            ? CuestionarioPregunta::findOrFail($this->editingPreguntaId)
            : new CuestionarioPregunta();

        $pregunta->fill($data['preguntaForm']);
        $pregunta->equipo_tipo_ids = $this->packIds($this->preguntaTipoIds);
        $pregunta->equipo_categoria_ids = $this->packIds($this->preguntaCategoriaIds);
        $pregunta->equipo_marca_ids = $this->packIds($this->preguntaMarcaIds);
        $pregunta->equipo_modelo_ids = $this->packIds($this->preguntaModeloIds);
        $pregunta->save();

        $this->preguntaModal = false;
        $this->resetPreguntaForm();
        $this->dispatch('swal', type: 'success', title: 'Pregunta guardada', text: 'La pregunta fue registrada correctamente.');
    }

    #[On('catalogos-inspeccion:delete')]
    public function deleteItem(string $type, int $id): void
    {
        match ($type) {
            'categoria' => $this->logicalDelete(CuestionarioCategoria::findOrFail($id)),
            'subcategoria' => $this->logicalDelete(CuestionarioSubCategoria::findOrFail($id)),
            'pregunta' => $this->logicalDelete(CuestionarioPregunta::findOrFail($id)),
        };

        if ($type === 'categoria' && $this->selectedCategoriaId === $id) {
            $this->selectedCategoriaId = null;
        }

        if ($type === 'subcategoria' && $this->selectedSubCategoriaId === $id) {
            $this->selectedSubCategoriaId = null;
        }

        $this->dispatch('swal', type: 'success', title: 'Registro eliminado', text: 'El registro fue eliminado correctamente.');
    }

    public function render()
    {
        $cuestionarioCategorias = CuestionarioCategoria::query()
            ->where('estado', 1)
            ->withCount('preguntas')
            ->when($this->searchCategoria !== '', fn ($query) => $query->where('descripcion', 'like', '%' . $this->searchCategoria . '%'))
            ->orderBy('descripcion')
            ->get();

        $cuestionarioSubCategorias = CuestionarioSubCategoria::query()
            ->where('estado', 1)
            ->withCount('preguntas')
            ->when($this->searchSubCategoria !== '', fn ($query) => $query->where('descripcion', 'like', '%' . $this->searchSubCategoria . '%'))
            ->orderBy('descripcion')
            ->get();

        $preguntas = CuestionarioPregunta::query()
            ->where('estado', 1)
            ->with(['categoria', 'subCategoria'])
            ->when($this->selectedCategoriaId, fn ($query) => $query->where('cuestionario_categoria_id', $this->selectedCategoriaId))
            ->when($this->selectedSubCategoriaId, fn ($query) => $query->where('cuestionario_sub_categoria_id', $this->selectedSubCategoriaId))
            ->when($this->searchPregunta !== '', function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('pregunta_enunciado', 'like', '%' . $this->searchPregunta . '%')
                        ->orWhere('equipo_tipo_ids', 'like', '%' . $this->searchPregunta . '%')
                        ->orWhere('equipo_categoria_ids', 'like', '%' . $this->searchPregunta . '%')
                        ->orWhere('equipo_marca_ids', 'like', '%' . $this->searchPregunta . '%')
                        ->orWhere('equipo_modelo_ids', 'like', '%' . $this->searchPregunta . '%');
                });
            })
            ->orderByDesc('id')
            ->paginate($this->perPagePreguntas);

        return view('livewire.inspecciones.catalogos-manager', [
            'cuestionarioCategorias' => $cuestionarioCategorias,
            'cuestionarioSubCategorias' => $cuestionarioSubCategorias,
            'preguntas' => $preguntas,
            'catalogoTipos' => Tipo::query()->where('estado', 1)->orderBy('tipo')->get(),
            'catalogoCategorias' => Categoria::query()->where('estado', 1)->orderBy('categoria')->get(),
            'catalogoMarcas' => Marca::query()->where('estado', 1)->orderBy('marca')->get(),
            'catalogoModelos' => Modelo::query()->where('estado', 1)->orderBy('modelo')->get(),
            'preguntaResumen' => fn (CuestionarioPregunta $pregunta) => $this->resumenPregunta($pregunta),
        ]);
    }

    private function resetCategoriaForm(): void
    {
        $this->editingCategoriaId = null;
        $this->categoriaForm = [
            'descripcion' => '',
            'estado' => 1,
        ];
    }

    private function resetSubCategoriaForm(): void
    {
        $this->editingSubCategoriaId = null;
        $this->subCategoriaForm = [
            'descripcion' => '',
            'estado' => 1,
        ];
    }

    private function resetPreguntaForm(): void
    {
        $this->editingPreguntaId = null;
        $this->preguntaForm = [
            'cuestionario_categoria_id' => $this->selectedCategoriaId,
            'cuestionario_sub_categoria_id' => $this->selectedSubCategoriaId,
            'pregunta_enunciado' => '',
            'ingeso_preguntar' => 1,
            'ingreso_respuesta_tipo' => '',
            'ingreso_respuesta_valores' => '',
            'salida_preguntar' => 1,
            'salida_respuesta_tipo' => '',
            'salida_respuesta_valores' => '',
            'permitir_observaciones' => 1,
            'estado' => 1,
        ];

        $this->preguntaTipoIds = [];
        $this->preguntaCategoriaIds = [];
        $this->preguntaMarcaIds = [];
        $this->preguntaModeloIds = [];
    }

    public function updatedPreguntaTipoIds($value): void
    {
        $this->preguntaTipoIds = $this->normalizeSelectedIds($value);
    }

    public function updatedPreguntaCategoriaIds($value): void
    {
        $this->preguntaCategoriaIds = $this->normalizeSelectedIds($value);
    }

    public function updatedPreguntaMarcaIds($value): void
    {
        $this->preguntaMarcaIds = $this->normalizeSelectedIds($value);
    }

    public function updatedPreguntaModeloIds($value): void
    {
        $this->preguntaModeloIds = $this->normalizeSelectedIds($value);
    }

    private function packIds(array $ids): ?string
    {
        $ids = collect($ids)
            ->filter(fn ($id) => filled($id))
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->sort()
            ->values()
            ->all();

        if ($ids === []) {
            return null;
        }

        return '.' . implode('.', $ids) . '.';
    }

    private function unpackIds(?string $ids): array
    {
        if (!$ids) {
            return [];
        }

        return collect(explode('.', trim($ids, '.')))
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->values()
            ->all();
    }

    private function normalizeSelectedIds($value): array
    {
        if (!is_array($value)) {
            return [];
        }

        return collect($value)
            ->filter(fn ($id) => filled($id))
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->all();
    }

    private function resumenPregunta(CuestionarioPregunta $pregunta): string
    {
        $parts = [];

        foreach ([
            'T' => $pregunta->equipo_tipo_ids,
            'C' => $pregunta->equipo_categoria_ids,
            'M' => $pregunta->equipo_marca_ids,
            'MO' => $pregunta->equipo_modelo_ids,
        ] as $label => $value) {
            if (!$value) {
                continue;
            }

            $parts[] = $label . ':' . implode(',', $this->unpackIds($value));
        }

        return $parts === [] ? 'Sin filtros de catalogo' : implode(' | ', $parts);
    }

    private function logicalDelete(object $record): void
    {
        $record->estado = 0;
        $record->deleted_by = auth()->id();
        $record->updated_by = auth()->id();
        $record->save();
    }
}
