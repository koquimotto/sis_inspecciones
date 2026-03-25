<?php

namespace Database\Seeders;
use App\Models\Empresa;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpresasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unidad = Empresa::updateOrCreate(
            ['razon_social' => 'UNIDAD MINERA DEMO S.A.C.'],
            [
                'tipo' => 'unidad_minera',
                'ruc' => '20123456789',
                'nombre_comercial' => 'UM DEMO',
                'estado' => 1,
            ]
        );

        Empresa::updateOrCreate(
            ['razon_social' => 'SERVICE DEMO S.R.L.'],
            [
                'tipo' => 'empresa',
                'unidad_minera_id' => $unidad->id,
                'ruc' => '20654321098',
                'nombre_comercial' => 'SERVICE DEMO',
                'estado' => 1,
            ]
        );
    }
    
}
