<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModelosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        /**
         * ✅ Tu migración:
         * Schema::create('modelos', function (Blueprint $table) {
         *   $table->id();
         *   $table->string('modelos')->nullable()->index();
         *   $table->string('modelo')->nullable()->index();
         *   $table->timestamps();
         * });
         *
         * Interpretación literal:
         * - modelos = CÓDIGO (string)  -> ej: "HILUX", "PC200", "D8T"
         * - modelo  = NOMBRE (string)  -> ej: "Hilux", "Excavadora PC200", "Bulldozer D8T"
         */

        $items = [
            // -------------------------
            // PICKUPS / SUV / VAN (genérico)
            // -------------------------
            ['HILUX', 'Hilux'],
            ['RAV4', 'RAV4'],
            ['FORTUNER', 'Fortuner'],
            ['LANDCRUISER', 'Land Cruiser'],
            ['PRADO', 'Prado'],
            ['COROLLA', 'Corolla'],
            ['YARIS', 'Yaris'],
            ['HIACE', 'Hiace'],
            ['URVAN', 'Urvan'],
            ['FRONTIER', 'Frontier'],
            ['XTRAIL', 'X-Trail'],
            ['L200', 'L200'],
            ['MONTERO', 'Montero / Pajero'],
            ['DMAX', 'D-Max'],

            // -------------------------
            // CAMIONES (series genéricas)
            // -------------------------
            ['NPR', 'Camión NPR'],
            ['NQR', 'Camión NQR'],
            ['FRR', 'Camión FRR'],
            ['FTR', 'Camión FTR'],
            ['HINO300', 'Hino 300 Series'],
            ['HINO500', 'Hino 500 Series'],
            ['HINO700', 'Hino 700 Series'],
            ['SCANIA_P', 'Scania P-series'],
            ['SCANIA_G', 'Scania G-series'],
            ['SCANIA_R', 'Scania R-series'],
            ['VOLVO_FH', 'Volvo FH'],
            ['VOLVO_FM', 'Volvo FM'],
            ['VOLVO_FMX', 'Volvo FMX'],

            // -------------------------
            // MAQUINARIA AMARILLA (excavadoras / cargadores / dozers / motoniveladoras)
            // -------------------------
            ['CAT320', 'Excavadora 320'],
            ['CAT336', 'Excavadora 336'],
            ['CAT950M', 'Cargador frontal 950M'],
            ['CAT988K', 'Cargador frontal 988K'],
            ['CAT140M', 'Motoniveladora 140M'],
            ['CATD6T', 'Bulldozer D6T'],
            ['CATD8T', 'Bulldozer D8T'],

            ['PC200', 'Excavadora PC200'],
            ['PC210', 'Excavadora PC210'],
            ['D65', 'Bulldozer D65'],
            ['WA380', 'Cargador frontal WA380'],
            ['GD655', 'Motoniveladora GD655'],

            ['JCB3CX', 'Retroexcavadora 3CX'],
            ['JCB4CX', 'Retroexcavadora 4CX'],
            ['JS220', 'Excavadora JS220'],

            ['EC210', 'Excavadora EC210'],
            ['EC220', 'Excavadora EC220'],
            ['L120H', 'Cargador frontal L120H'],
            ['A40G', 'Dumper articulado A40G'],

            ['DX225', 'Excavadora DX225'],
            ['DL300', 'Cargador frontal DL300'],

            ['SY215', 'Excavadora SY215'],
            ['SY365', 'Excavadora SY365'],

            ['XE215', 'Excavadora XE215'],
            ['LW500', 'Cargador frontal LW500'],

            ['CLG856', 'Cargador frontal CLG856'],
            ['CLG922', 'Excavadora CLG922'],

            // -------------------------
            // COMPACTOS / TELEHANDLER / DUMPER / MONTA CARGA
            // -------------------------
            ['S650', 'Minicargador S650'],
            ['T590', 'Minicargador oruga T590'],
            ['MT732', 'Telehandler MT 732'],
            ['MT1840', 'Telehandler MT 1840'],
            ['TA300', 'Dumper TA300'],
            ['H25FT', 'Montacargas H2.5FT'],
            ['H30FT', 'Montacargas H3.0FT'],
            ['GDP25VX', 'Montacargas GDP25VX'],
            ['GDP30VX', 'Montacargas GDP30VX'],
        ];

        // Idempotente: clave por 'modelos' (código)
        foreach ($items as [$codigo, $nombre]) {
            DB::table('modelos')->updateOrInsert(
                ['modelos' => $codigo],
                [
                    'modelos'    => $codigo,
                    'modelo'     => $nombre,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}
