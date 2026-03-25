<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = [
            ['name' => 'admin',     'label' => 'Administrador', 'estado' => 1],
            ['name' => 'operador',  'label' => 'Operador',      'estado' => 1],
            ['name' => 'inspector', 'label' => 'Inspector',     'estado' => 1],
        ];

        foreach ($rows as $r) {
            DB::table('roles')->updateOrInsert(
                ['name' => $r['name']],
                [
                    'label' => $r['label'],
                    'estado' => $r['estado'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
