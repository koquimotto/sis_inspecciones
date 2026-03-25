<?php

namespace App\Livewire\Usuarios;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use App\Actions\Usuarios\UsuarioAction;
use App\Models\User;

class Modal extends Component
{
    public bool $modal = true;

    public ?int $editingId = null;
    public ?int $persona_id = null;

    public array $empresaOptions = [];
    public array $rolOptions = [];

    // Flags: por defecto DNI/email, a menos que el usuario lo cambie
    public bool $usernameTouched = false;
    public bool $emailTouched = false;

    // Para detectar cambio de DNI y limpiar
    public string $dniLast = '';

    public array $persona = [
        'dni' => '',
        'nombres' => '',
        'apellido_paterno' => '',
        'apellido_materno' => '',
        'email' => '',
        'telefono' => '',
    ];

    public array $state = [
        'empresa_id' => '',
        'username' => '',
        'email' => '',
        'password' => '',
        'password_confirmation' => '',
        'estado' => 1,
        'name' => '',
    ];

    /** @var int[] */
    public array $selectedRoles = [];

    protected $listeners = [
        'usuarios-modal:open' => 'open',
    ];

    public function mount(UsuarioAction $action): void
    {
        $this->empresaOptions = $action->empresaOptions();
        $this->rolOptions     = $action->rolOptions();
    }

    public function render()
    {
        return view('livewire.usuarios.modal');
    }

    public function open(array $payload = []): void
    {
        $this->resetValidation();
        $this->resetErrorBag();

        $id = $payload['id'] ?? null;

        $this->resetForm();

        if (!empty($id) && (int)$id > 0) {
            $this->editingId = (int) $id;

            $u = User::query()->with('persona')->findOrFail($this->editingId);

            $this->state['empresa_id'] = $u->empresa_id ?? '';
            $this->state['username']   = $u->username ?? '';
            $this->state['email']      = $u->email ?? '';
            $this->state['estado']     = (int)($u->estado ?? 1);
            $this->state['name']       = $u->name ?? '';

            // En edición no sobreescribimos user/email
            $this->usernameTouched = true;
            $this->emailTouched = true;

            if ($u->persona) {
                $this->persona_id = $u->persona->id;
                $this->persona['dni'] = $u->persona->numero_documento ?? '';
                $this->persona['nombres'] = $u->persona->nombres ?? '';
                $this->persona['apellido_paterno'] = $u->persona->apellido_paterno ?? '';
                $this->persona['apellido_materno'] = $u->persona->apellido_materno ?? '';
                $this->persona['email'] = $u->persona->email ?? '';
                $this->persona['telefono'] = $u->persona->telefono ?? '';
                $this->dniLast = (string)($this->persona['dni'] ?? '');
            }

            $this->selectedRoles = $this->currentRoleIds($u);
        }

        $this->modal = true;
    }

    /** Si el usuario cambia el username manualmente, no se sobreescribe con DNI */
    public function updatedStateUsername($value): void
    {
        $this->usernameTouched = true;
    }

    /** Si el usuario cambia el email manualmente, no se sobreescribe con email persona */
    public function updatedStateEmail($value): void
    {
        $this->emailTouched = true;
    }

    /**
     * Al cambiar DNI (con defer se ejecuta al blur), limpiamos datos para evitar "pegados".
     * Además: username por defecto = DNI (si no lo tocó).
     */
    public function updatedPersonaDni($value): void
    {
        $dni = trim((string) $value);

        if ($dni !== '' && $dni !== $this->dniLast) {
            $this->persona_id = null;

            $this->persona['nombres'] = '';
            $this->persona['apellido_paterno'] = '';
            $this->persona['apellido_materno'] = '';
            $this->persona['email'] = '';
            $this->persona['telefono'] = '';

            if (!$this->usernameTouched) {
                $this->state['username'] = $dni;
            }

            if (!$this->editingId && empty($this->state['password'])) {
                $this->state['password'] = $dni;
                $this->state['password_confirmation'] = $dni;
            }

            if (!$this->emailTouched) {
                $this->state['email'] = '';
            }

            $this->refreshName();
            $this->dniLast = $dni;
        }
    }

    public function buscarDni(UsuarioAction $action): void
    {
        $dni = trim((string) $this->persona['dni']);

        $this->validateOnly('persona.dni', [
            'persona.dni' => ['required', 'digits:8'],
        ]);

        // Limpia SIEMPRE antes de consultar
        if ($dni !== $this->dniLast) {
            $this->persona_id = null;
            $this->persona['nombres'] = '';
            $this->persona['apellido_paterno'] = '';
            $this->persona['apellido_materno'] = '';
            $this->persona['email'] = '';
            $this->persona['telefono'] = '';
            $this->dniLast = $dni;

            if (!$this->emailTouched) {
                $this->state['email'] = '';
            }
        }

        $p = $action->findPersonaByDni($dni);

        if ($p) {
            $this->persona_id = $p->id;
            $this->persona['nombres'] = $p->nombres ?? '';
            $this->persona['apellido_paterno'] = $p->apellido_paterno ?? '';
            $this->persona['apellido_materno'] = $p->apellido_materno ?? '';
            $this->persona['email'] = $p->email ?? '';
            $this->persona['telefono'] = $p->telefono ?? '';
        } else {
            $this->persona_id = null;
        }

        // Defaults: username = DNI si no lo tocó
        if (!$this->usernameTouched) {
            $this->state['username'] = $dni;
        }

        // Defaults: password = DNI (solo creación) si está vacío
        if (!$this->editingId && empty($this->state['password'])) {
            $this->state['password'] = $dni;
            $this->state['password_confirmation'] = $dni;
        }

        // Defaults: email user = email persona si no lo tocó
        if (!$this->emailTouched && !empty($this->persona['email'])) {
            $this->state['email'] = $this->persona['email'];
        }

        $this->refreshName();
    }

    public function limpiarPersona(): void
    {
        $dni = $this->persona['dni'] ?? '';

        $this->persona_id = null;

        $this->persona = [
            'dni' => $dni,
            'nombres' => '',
            'apellido_paterno' => '',
            'apellido_materno' => '',
            'email' => '',
            'telefono' => '',
        ];

        if (!$this->emailTouched) {
            $this->state['email'] = '';
        }

        $this->refreshName();
    }

    public function save(UsuarioAction $action): void
    {
        // Siempre recalcular name
        $this->refreshName();

        // Defaults finales antes de validar
        $dni = trim((string)($this->persona['dni'] ?? ''));

        if (!$this->usernameTouched) {
            $this->state['username'] = $dni;
        }
        if (!$this->emailTouched && !empty($this->persona['email'])) {
            $this->state['email'] = $this->persona['email'];
        }

        // Roles: alerta sin obligar a cambiar de tab
        $requireRoles = !empty($this->rolOptions);
        if ($requireRoles && empty($this->selectedRoles)) {
            $this->addError('selectedRoles', 'Debe seleccionar al menos un rol.');
            $this->dispatch('swal', [
                'icon'  => 'warning',
                'title' => 'Faltan roles',
                'text'  => 'Seleccione al menos un rol antes de guardar.',
            ]);
            return;
        }

        // Validación con SweetAlert si falta algo
        try {
            $this->validate($this->rules());
        } catch (ValidationException $e) {
            $this->dispatch('swal', [
                'icon'  => 'error',
                'title' => 'Campos incompletos',
                'text'  => 'Revise los campos marcados e intente nuevamente.',
            ]);
            throw $e;
        }

        try {
            DB::transaction(function () use ($action) {
                // 1) Persona (upsert por DNI)
                $persona = $action->upsertPersona($this->persona);
                $this->persona_id = $persona->id;

                // 2) User create/update
                if ($this->editingId) {
                    $u = User::findOrFail($this->editingId);
                    $action->updateUser($u, $this->state, $persona->id);
                } else {
                    $u = $action->createUser($this->state, $persona->id);
                    $this->editingId = $u->id;
                }

                // 3) Roles
                $action->syncRoles($u, $this->selectedRoles);
            });
        } catch (\Throwable $e) {
            $this->dispatch('swal', [
                'icon'  => 'error',
                'title' => 'No se pudo guardar',
                'text'  => 'Ocurrió un error. Verifique e intente nuevamente.',
            ]);
            throw $e;
        }

        // ✅ Cerrar modal y refrescar tabla
        $isEdit = (bool) $this->editingId;
        $this->modal = false;
        $this->dispatch('usuarios-tabla:refresh');

        // ✅ SweetAlert de éxito (encima del modal)
        $this->dispatch('swal', [
            'icon'  => 'success',
            'title' => $isEdit ? 'Usuario guardado' : 'Usuario registrado',
            'text'  => 'Los cambios se guardaron correctamente.',
            'timer' => 1400,
            'allowOutsideClick' => false,
            'allowEscapeKey' => false,
        ]);

        $this->resetForm();
    }

    private function rules(): array
    {
        $userId = $this->editingId;

        $rules = [
            'persona.dni' => ['required', 'digits:8'],

            'state.empresa_id' => ['required'],

            // Persona
            'persona.nombres' => ['required', 'string', 'max:120'],
            'persona.apellido_paterno' => ['required', 'string', 'max:120'],
            'persona.apellido_materno' => ['required', 'string', 'max:120'],
            'persona.email' => ['nullable', 'email', 'max:150'],
            'persona.telefono' => ['nullable', 'string', 'max:50'],

            // User
            'state.username' => ['required', 'string', 'max:50', Rule::unique('users', 'username')->ignore($userId)],
            'state.email'    => ['nullable', 'email', 'max:150', Rule::unique('users', 'email')->ignore($userId)],
            'state.estado'   => ['required', Rule::in([0,1])],
        ];

        // Roles: requerido solo si hay opciones
        $rules['selectedRoles'] = !empty($this->rolOptions)
            ? ['required', 'array', 'min:1']
            : ['nullable', 'array'];

        // Password: required en creación, opcional en edición
        $rules['state.password'] = $this->editingId
            ? ['nullable', 'string', 'min:6', 'confirmed']
            : ['required', 'string', 'min:6', 'confirmed'];

        return $rules;
    }

    private function resetForm(): void
    {
        $this->editingId = null;
        $this->persona_id = null;
        $this->selectedRoles = [];

        $this->usernameTouched = false;
        $this->emailTouched = false;
        $this->dniLast = '';

        $this->persona = [
            'dni' => '',
            'nombres' => '',
            'apellido_paterno' => '',
            'apellido_materno' => '',
            'email' => '',
            'telefono' => '',
        ];

        $this->state = [
            'empresa_id' => '',
            'username' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
            'estado' => 1,
            'name' => '',
        ];
    }

    private function refreshName(): void
    {
        $full = trim(
            ($this->persona['nombres'] ?? '') . ' ' .
            ($this->persona['apellido_paterno'] ?? '') . ' ' .
            ($this->persona['apellido_materno'] ?? '')
        );

        $this->state['name'] = $full;
    }

    private function currentRoleIds(User $u): array
    {
        // Spatie
        if (method_exists($u, 'roles')) {
            try {
                return $u->roles()->pluck('id')->map(fn($x)=>(int)$x)->all();
            } catch (\Throwable $e) {}
        }

        // Fallback role_user
        try {
            return DB::table('role_user')
                ->where('user_id', $u->id)
                ->pluck('role_id')
                ->map(fn($x)=>(int)$x)
                ->all();
        } catch (\Throwable $e) {}

        return [];
    }
}