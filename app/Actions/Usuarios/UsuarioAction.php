<?php

namespace App\Actions\Usuarios;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Persona;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UsuarioAction
{
    public function queryUsuarios(array $filters = []): Builder
    {
        $q        = trim((string)($filters['q'] ?? ''));
        $estado   = $filters['estado'] ?? null;
        $orderBy  = (string)($filters['order_by'] ?? 'id');
        $orderDir = strtolower((string)($filters['order_dir'] ?? 'desc')) === 'asc' ? 'asc' : 'desc';

        $allowedOrderBy = ['id', 'name', 'email', 'estado', 'created_at'];
        if (!in_array($orderBy, $allowedOrderBy, true)) {
            $orderBy = 'id';
        }

        return User::query()
            ->select(['id', 'name', 'email', 'username', 'estado', 'created_at'])
            // ->with('persona') // si necesitas DNI en tabla, actívalo
            ->when($q !== '', function (Builder $qq) use ($q) {
                $qq->where(function (Builder $w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%")
                      ->orWhere('username', 'like', "%{$q}%");
                });
            })
            ->when($estado !== null && $estado !== '', function (Builder $qq) use ($estado) {
                $qq->where('estado', (int)$estado);
            })
            ->orderBy($orderBy, $orderDir);
    }

    /**
     * Helper por si quieres seguir usando "listaUsuarios" desde Livewire.
     */
    public function listaUsuarios(array $filters = [], int $perPage = 10)
    {
        return $this->queryUsuarios($filters)->paginate($perPage);
    }
    
    /** Opciones de empresas para el select */
    public function empresaOptions(): array
    {
        return Empresa::query()
            ->select(['id', 'razon_social', 'nombre_comercial', 'ruc', 'tipo'])
            ->orderBy('razon_social')
            ->get()
            ->map(function ($e) {
                $label = trim(($e->razon_social ?? '') . ' ' . ($e->nombre_comercial ? "({$e->nombre_comercial})" : ''));
                $extra = $e->ruc ? " - {$e->ruc}" : '';
                return [
                    'id' => $e->id,
                    'label' => $label . $extra,
                ];
            })
            ->all();
    }

    /**
     * Roles: soporta Spatie si existe; caso contrario usa tabla roles + pivot role_user.
     * Devuelve: [ ['id'=>..., 'label'=>..., 'hint'=>...], ... ]
     */
     public function rolOptions(): array
    {
        // Spatie (si existe)
        $roleClass = 'Spatie\\Permission\\Models\\Role';
        if (class_exists($roleClass)) {
            return $roleClass::query()
                ->select(['id', 'name'])
                ->orderBy('name')
                ->get()
                ->map(fn ($r) => [
                    'id'    => (int) $r->id,
                    'label' => $this->prettyRole($r->name),
                    'hint'  => $r->name,
                ])
                ->all();
        }

        // ✅ Si NO existe tabla roles, devolver vacío (y no explota)
        if (!Schema::hasTable('roles')) {
            return [];
        }

        return DB::table('roles')
            ->select(['id', 'name', 'label'])
            ->where('estado', 1)
            ->orderBy('name')
            ->get()
            ->map(fn ($r) => [
                'id'    => (int) $r->id,
                'label' => $r->label ?: $this->prettyRole($r->name),
                'hint'  => $r->name,
            ])
            ->all();
    }

    private function prettyRole(string $name): string
    {
        return match ($name) {
            'admin' => 'Administrador',
            'operador' => 'Operador',
            'inspector' => 'Inspector',
            default => ucfirst(str_replace('_', ' ', $name)),
        };
    }

    public function findPersonaByDni(string $dni): ?Persona
    {
        return Persona::query()
            ->where('numero_documento', $dni)
            ->first();
    }
    
    public function syncRoles(User $user, array $selectedRoles): void
{
    $ids = array_values(array_unique(array_map('intval', $selectedRoles)));

    $roleClass = 'Spatie\\Permission\\Models\\Role';

    if (class_exists($roleClass)) {
        $names = $roleClass::query()
            ->whereIn('id', $ids)
            ->pluck('name')
            ->all();

        $user->syncRoles($names);
        return;
    }

    // ✅ si no hay tablas, no hacemos nada
    if (!Schema::hasTable('role_user') || !Schema::hasTable('roles')) {
        return;
    }

    DB::table('role_user')->where('user_id', $user->id)->delete();

    $rows = array_map(fn ($rid) => [
        'user_id' => $user->id,
        'role_id' => (int) $rid,
    ], $ids);

    if (!empty($rows)) {
        DB::table('role_user')->insert($rows);
    }
}

    public function upsertPersona(array $persona): Persona
    {
        $dni = trim((string)($persona['dni'] ?? ''));

        return Persona::updateOrCreate(
            ['numero_documento' => $dni],
            [
                'tipo_documento'   => 'DNI',
                'nombres'          => $persona['nombres'] ?? '',
                'apellido_paterno' => $persona['apellido_paterno'] ?? '',
                'apellido_materno' => $persona['apellido_materno'] ?? '',
                'email'            => $persona['email'] ?? null,
                'telefono'         => $persona['telefono'] ?? null,
                'estado'           => 1,
            ]
        );
    }

    public function createUser(array $state, int $personaId): User
    {
        return User::create([
            'persona_id' => $personaId,
            'empresa_id' => $state['empresa_id'],
            'name'       => $state['name'],
            'email'      => $state['email'] ?? null,
            'username'   => $state['username'],
            'password'   => Hash::make($state['password']),
            'estado'     => (int)$state['estado'],
        ]);
    }

    public function updateUser(User $user, array $state, int $personaId): void
    {
        $data = [
            'persona_id' => $personaId,
            'empresa_id' => $state['empresa_id'],
            'name'       => $state['name'],
            'email'      => $state['email'] ?? null,
            'username'   => $state['username'],
            'estado'     => (int)$state['estado'],
        ];

        if (!empty($state['password'])) {
            $data['password'] = Hash::make($state['password']);
        }

        $user->update($data);
    }

    
}
