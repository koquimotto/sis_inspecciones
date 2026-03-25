<?php

namespace App\Actions\Empresas;

use App\Models\Empresa;
use App\Models\Persona;
use App\Models\EmpresaContacto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmpresaAction
{
    public function find(int $id): ?Empresa
    {
        return Empresa::query()
            ->with([
                'contactoPrincipal.persona:id,tipo_documento,numero_documento,cargo,nombres,apellido_paterno,apellido_materno,email,telefono,notas,estado'
            ])
            ->find($id);
    }

    public function findPersonaByDocumento(string $numeroDocumento): ?Persona
    {
        return Persona::query()
            ->where('numero_documento', trim($numeroDocumento))
            ->first();
    }

    public function storeConContacto(array $empresaData, array $contactoData): Empresa
    {
        return DB::transaction(function () use ($empresaData, $contactoData) {
            $empresa = Empresa::create([
                ...$this->mapEmpresa($empresaData),
                'user_id' => Auth::id(),
            ]);

            $persona = $this->upsertPersona($contactoData);

            EmpresaContacto::create([
                'empresa_id' => $empresa->id,
                'persona_id' => $persona->id,
                'email'      => $contactoData['email'] ?? null,
                'telefono'   => $contactoData['telefono'] ?? null,
                'estado'     => 1,
                'user_id'    => Auth::id(),
            ]);

            return $empresa->load([
                'contactoPrincipal.persona'
            ]);
        });
    }

    public function updateConContacto(int $empresaId, array $empresaData, array $contactoData): Empresa
    {
        return DB::transaction(function () use ($empresaId, $empresaData, $contactoData) {
            $empresa = Empresa::query()
                ->with('contactoPrincipal')
                ->findOrFail($empresaId);

            $empresa->update([
                ...$this->mapEmpresa($empresaData),
                'user_id' => Auth::id(),
            ]);

            $personaIdActual = optional($empresa->contactoPrincipal)->persona_id;
            $persona = $this->upsertPersona($contactoData, $personaIdActual);

            EmpresaContacto::updateOrCreate(
                ['empresa_id' => $empresa->id],
                [
                    'persona_id' => $persona->id,
                    'email'      => $contactoData['email'] ?? null,
                    'telefono'   => $contactoData['telefono'] ?? null,
                    'estado'     => 1,
                    'user_id'    => Auth::id(),
                ]
            );

            return $empresa->load([
                'contactoPrincipal.persona'
            ]);
        });
    }

    public function desactivar(int $id): void
    {
        DB::transaction(function () use ($id) {
            $empresa = Empresa::findOrFail($id);
            $empresa->update([
                'estado' => 0,
                'user_id' => Auth::id(),
            ]);
        });
    }

    private function upsertPersona(array $data, ?int $personaId = null): Persona
    {
        if ($personaId) {
            $persona = Persona::find($personaId);

            if ($persona) {
                $persona->update($this->mapPersona($data));
                return $persona;
            }
        }

        return Persona::updateOrCreate(
            ['numero_documento' => trim((string) ($data['numero_documento'] ?? ''))],
            $this->mapPersona($data)
        );
    }

    private function mapEmpresa(array $s): array
    {
        return [
            'tipo'             => $s['tipo'] ?? 'empresa',
            'unidad_minera_id' => $s['unidad_minera_id'] ?? null,
            'ruc'              => $s['ruc'] ?? null,
            'razon_social'     => $s['razon_social'] ?? null,
            'nombre_comercial' => $s['nombre_comercial'] ?? null,
            'email'            => $s['email'] ?? null,
            'telefono'         => $s['telefono'] ?? null,
            'pais_id'          => $s['pais_id'] ?? null,
            'region_id'        => $s['region_id'] ?? null,
            'ciudad'           => $s['ciudad'] ?? null,
            'direccion'        => $s['direccion'] ?? null,
            'estado'           => (int) ($s['estado'] ?? 1),
        ];
    }

    private function mapPersona(array $data): array
    {
        return [
            'tipo_documento'   => $data['tipo_documento'] ?? 'DNI',
            'numero_documento' => trim((string) ($data['numero_documento'] ?? '')),
            'cargo'            => trim((string) ($data['cargo'] ?? '')) ?: null,
            'nombres'          => trim((string) ($data['nombres'] ?? '')),
            'apellido_paterno' => trim((string) ($data['apellido_paterno'] ?? '')),
            'apellido_materno' => trim((string) ($data['apellido_materno'] ?? '')),
            'email'            => trim((string) ($data['email'] ?? '')) ?: null,
            'telefono'         => trim((string) ($data['telefono'] ?? '')) ?: null,
            'notas'            => trim((string) ($data['notas'] ?? '')) ?: null,
            'estado'           => (int) ($data['estado'] ?? 1),
        ];
    }
}