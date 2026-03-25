<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CargosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        
        $cargos = [
            // Formato: [codigo, cargo, estado]
            ['ADM', 'Administrador', 1],
            ['DIR', 'Director', 1],
            ['GER', 'Gerente General', 1],
            ['SUB', 'Subgerente', 1],
            ['JEF', 'Jefe de Área', 1],
            ['SUP', 'Supervisor', 1],
            ['COO', 'Coordinador', 1],
            ['ASI', 'Asistente', 1],
            ['ANA', 'Analista', 1],

            // Operaciones / campo
            ['OPE', 'Operador', 1],
            ['OPE-MAQ', 'Operador de Maquinaria', 1],
            ['CHO', 'Chofer / Conductor', 1],
            ['TEC', 'Técnico', 1],
            ['TEC-MEC', 'Técnico Mecánico', 1],
            ['TEC-ELC', 'Técnico Electricista', 1],
            ['TEC-ELE', 'Técnico Electrónico', 1],
            ['TEC-SST', 'Técnico de Seguridad y Salud en el Trabajo', 1],
            ['MEC', 'Mecánico', 1],
            ['ELC', 'Electricista', 1],
            ['SOL', 'Soldador', 1],
            ['ALM', 'Almacenero', 1],
            ['LOG', 'Logística', 1],
            ['COM', 'Compras', 1],

            // Profesional / ingeniería
            ['ING-CIV', 'Ingeniero Civil', 1],
            ['ING-IND', 'Ingeniero Industrial', 1],
            ['ING-MEC', 'Ingeniero Mecánico', 1],
            ['ING-ELC', 'Ingeniero Electricista', 1],
            ['ING-SIS', 'Ingeniero de Sistemas', 1],
            ['ING-AMB', 'Ingeniero Ambiental', 1],
            ['ING-GEO', 'Ingeniero Geólogo', 1],
            ['ARQ', 'Arquitecto', 1],
            ['TOP', 'Topógrafo', 1],

            // Administración / finanzas / legal
            ['CON', 'Contador', 1],
            ['TES', 'Tesorero', 1],
            ['RRHH', 'Recursos Humanos', 1],
            ['LEG', 'Asesor Legal', 1],
            ['ADM-OF', 'Administración (Oficina)', 1],

            // Comercial / atención
            ['VEN', 'Vendedor', 1],
            ['ASE-COM', 'Asesor Comercial', 1],
            ['ATE', 'Atención al Cliente', 1],
            ['MKT', 'Marketing', 1],

            // TI
            ['DEV', 'Desarrollador', 1],
            ['SOP', 'Soporte Técnico', 1],
            ['INF', 'Infraestructura / Redes', 1],

            // Otros
            ['CAL', 'Calidad', 1],
            ['DOC', 'Documentación', 1],
            ['PRA', 'Practicante', 1],
        ];

        foreach ($cargos as [$codigo, $cargo, $estado]) {
            DB::table('cargos')->updateOrInsert(
                ['codigo' => $codigo],
                [
                    'codigo'     => $codigo,
                    'cargo'      => $cargo,
                    'estado'     => (int) $estado,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}
