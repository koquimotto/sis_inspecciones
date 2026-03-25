<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        /**
         * ✅ Tu migración:
         * - tabla: categorias
         * - columnas: codigo (string), categoria (string), estado (tinyInteger default 1), timestamps
         */

        $categorias = [
            // Formato: [codigo, categoria, estado]
            // --- Vehículos / automotriz ---
            ['VEH-PIC', 'Vehículo - Pickup', 1],
            ['VEH-SUV', 'Vehículo - SUV', 1],
            ['VEH-SED', 'Vehículo - Sedán', 1],
            ['VEH-HBK', 'Vehículo - Hatchback', 1],
            ['VEH-VAN', 'Vehículo - Van', 1],
            ['VEH-MIN', 'Vehículo - Minibús', 1],
            ['VEH-BUS', 'Vehículo - Bus', 1],

            // --- Camiones / transporte pesado ---
            ['CAM-LIG', 'Camión - Liviano', 1],
            ['CAM-MED', 'Camión - Mediano', 1],
            ['CAM-PES', 'Camión - Pesado', 1],
            ['CAM-TRC', 'Tractocamión', 1],
            ['CAM-VOL', 'Volquete', 1],
            ['CAM-CIS', 'Cisterna', 1],
            ['CAM-FRG', 'Furgón', 1],
            ['CAM-PLT', 'Plataforma', 1],
            ['CAM-BAR', 'Baranda', 1],

            // --- Maquinaria amarilla / construcción ---
            ['MAQ-EXC', 'Excavadora', 1],
            ['MAQ-RET', 'Retroexcavadora', 1],
            ['MAQ-CAR', 'Cargador frontal', 1],
            ['MAQ-MIN', 'Minicargador', 1],
            ['MAQ-DOZ', 'Bulldozer / Tractor oruga', 1],
            ['MAQ-MOT', 'Motoniveladora', 1],
            ['MAQ-ROD', 'Rodillo compactador', 1],
            ['MAQ-COM', 'Compactadora', 1],
            ['MAQ-GRU', 'Grúa', 1],
            ['MAQ-PLA', 'Plataforma elevadora', 1],
            ['MAQ-TEH', 'Telehandler', 1],
            ['MAQ-DMP', 'Dumper articulado', 1],
            ['MAQ-PAV', 'Pavimentadora / Terminadora', 1],
            ['MAQ-FRE', 'Fresadora', 1],
            ['MAQ-ZAN', 'Zanjadora', 1],
            ['MAQ-PER', 'Perforadora', 1],
            ['MAQ-TRI', 'Trituradora / Chancadora', 1],
            ['MAQ-PLN', 'Planta (Asfalto / Concreto)', 1],

            // --- Equipos industriales / energía / taller ---
            ['EQP-MON', 'Montacargas', 1],
            ['EQP-GEN', 'Generador eléctrico', 1],
            ['EQP-COM', 'Compresor de aire', 1],
            ['EQP-SOL', 'Soldadora', 1],
            ['EQP-BOM', 'Bomba (agua / lodo)', 1],
            ['EQP-HID', 'Unidad hidráulica', 1],
            ['EQP-ILU', 'Torre de iluminación', 1],
            ['EQP-HER', 'Herramienta eléctrica', 1],

            // --- Agrícola (si aplica) ---
            ['AGR-TRC', 'Tractor agrícola', 1],
            ['AGR-COB', 'Cosechadora', 1],
            ['AGR-PUL', 'Pulverizadora', 1],
            ['AGR-IMP', 'Implemento agrícola', 1],

            // --- Repuestos / accesorios (si lo vas a usar) ---
            ['REP-MOT', 'Repuesto - Motor', 1],
            ['REP-TRN', 'Repuesto - Transmisión', 1],
            ['REP-HID', 'Repuesto - Hidráulico', 1],
            ['REP-ELC', 'Repuesto - Eléctrico', 1],
            ['REP-FIL', 'Repuesto - Filtros', 1],
            ['REP-NEU', 'Repuesto - Neumáticos / Llantas', 1],
            ['REP-BAT', 'Repuesto - Baterías', 1],
        ];

        // Idempotente: clave por 'codigo'
        foreach ($categorias as [$codigo, $categoria, $estado]) {
            DB::table('categorias')->updateOrInsert(
                ['codigo' => $codigo],
                [
                    'codigo'     => $codigo,
                    'categoria'  => $categoria,
                    'estado'     => (int) $estado,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}
