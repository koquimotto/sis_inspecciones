<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        // ✅ Busca el país PERÚ en tu tabla 'paises' (por codigo ISO2 = 'PE')
        // Si no existe, igual insertará regiones con pais_id = null.
        $peruId = DB::table('paises')
            ->where('codigo', 'PE')
            ->value('id');

        // Estructura EXACTA según tu migración:
        // pais_id (nullable), region (nullable), codigo (nullable), timestamps
        $regiones = [
            // [codigo_region, region]
            ['AMA', 'Amazonas'],
            ['ANC', 'Áncash'],
            ['APU', 'Apurímac'],
            ['ARE', 'Arequipa'],
            ['AYA', 'Ayacucho'],
            ['CAJ', 'Cajamarca'],
            ['CAL', 'Callao'],
            ['CUS', 'Cusco'],
            ['HUV', 'Huancavelica'],
            ['HUC', 'Huánuco'],
            ['ICA', 'Ica'],
            ['JUN', 'Junín'],
            ['LAL', 'La Libertad'],
            ['LAM', 'Lambayeque'],
            ['LIM', 'Lima'],
            ['LOR', 'Loreto'],
            ['MDD', 'Madre de Dios'],
            ['MOQ', 'Moquegua'],
            ['PAS', 'Pasco'],
            ['PIU', 'Piura'],
            ['PUN', 'Puno'],
            ['SAM', 'San Martín'],
            ['TAC', 'Tacna'],
            ['TUM', 'Tumbes'],
            ['UCA', 'Ucayali'],
        ];

        // Idempotente: clave por (pais_id + codigo) si hay pais_id, si no, por codigo
        foreach ($regiones as [$codigo, $region]) {
            $where = ['codigo' => $codigo];
            if (!is_null($peruId)) {
                $where['pais_id'] = $peruId;
            }

            DB::table('regiones')->updateOrInsert(
                $where,
                [
                    'pais_id'    => $peruId,
                    'region'     => $region,
                    'codigo'     => $codigo,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}
