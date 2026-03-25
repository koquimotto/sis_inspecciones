<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Persona;
use App\Models\Empresa;

class UsuariosSeeder extends Seeder
{
    private string $dominioCorreo = 'sis-cursos.test';

    private function correo(string $alias): string
    {
        return "{$alias}@{$this->dominioCorreo}";
    }

    private function nombreCompleto(Persona $p): string
    {
        return trim($p->nombres . ' ' . $p->apellido_paterno . ' ' . $p->apellido_materno);
    }

    private function upsertPersona(array $data): Persona
    {
        // Evita duplicados al re-seed: clave por numero_documento
        return Persona::updateOrCreate(
            ['numero_documento' => $data['numero_documento']],
            [
                'tipo_documento'   => $data['tipo_documento'] ?? 'DNI',
                'nombres'          => $data['nombres'],
                'apellido_paterno' => $data['apellido_paterno'],
                'apellido_materno' => $data['apellido_materno'],
                'email'            => $data['email'] ?? null,
                'telefono'         => $data['telefono'] ?? null,
            ]
        );
    }

    private function upsertUser(Persona $p, ?int $empresaId, string $aliasEmail, string $password = '12345678'): User
    {
        // Login por username (DNI)
        return User::updateOrCreate(
            ['username' => $p->numero_documento],
            [
                'name'       => $this->nombreCompleto($p),
                'email'      => $this->correo($aliasEmail),
                'password'   => Hash::make($password),
                'persona_id' => $p->id,
                'empresa_id' => $empresaId,
                'estado'     => 1,
                'avatar'     => null,
            ]
        );
    }

    public function run(): void
    {
        DB::transaction(function () {

            $unidad  = Empresa::where('tipo', 'unidad_minera')->first();
            $service = Empresa::where('tipo', 'service')->first();

            $unidadId  = $unidad?->id;
            $serviceId = $service?->id;

            // ===================== ADMIN =====================
            $pAdmin = $this->upsertPersona([
                'numero_documento' => '70495760',
                'nombres'          => 'Luis',
                'apellido_paterno' => 'Paredes',
                'apellido_materno' => 'Caipo',
                'email'            => $this->correo('admin'),
            ]);
            $this->upsertUser($pAdmin, null, 'admin', '12345678');

            // ===================== UNIDAD MINERA =====================
            $pUM = $this->upsertPersona([
                'numero_documento' => '43931957',
                'nombres'          => 'Arturo David',
                'apellido_paterno' => 'Gonzales',
                'apellido_materno' => 'Briones',
                'email'            => 'abriones@elcumbe.com.pe',
            ]);
            $this->upsertUser($pUM, $unidadId, 'um', '43931957');

            // ===================== SERVICE =====================
            $pService = $this->upsertPersona([
                'numero_documento' => '74581236',
                'nombres'          => 'Carlos',
                'apellido_paterno' => 'Vargas',
                'apellido_materno' => 'Rojas',
                'email'            => $this->correo('service'),
            ]);
            $this->upsertUser($pService, $serviceId, 'service', '12345678');

            // ===================== DOCENTE =====================
            $pDoc = $this->upsertPersona([
                'numero_documento' => '48921763',
                'nombres'          => 'Renato',
                'apellido_paterno' => 'Salazar',
                'apellido_materno' => 'Paredes',
                'email'            => $this->correo('docente'),
            ]);
            $this->upsertUser($pDoc, null, 'docente', '12345678');

            // ===================== ALUMNO =====================
            $pAlu = $this->upsertPersona([
                'numero_documento' => '53609418',
                'nombres'          => 'Bruno',
                'apellido_paterno' => 'Huaman',
                'apellido_materno' => 'Torres',
                'email'            => $this->correo('alumno'),
            ]);
            $this->upsertUser($pAlu, null, 'alumno', '12345678');
        });
    }
}
