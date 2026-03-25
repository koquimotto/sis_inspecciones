<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarcasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        
        $marcas = [
            // Formato: [codigo, marca]

            // --- Automotriz (livianos) ---
            ['TOY', 'Toyota'],
            ['HYU', 'Hyundai'],
            ['KIA', 'Kia'],
            ['NIS', 'Nissan'],
            ['HON', 'Honda'],
            ['MAZ', 'Mazda'],
            ['MIT', 'Mitsubishi'],
            ['SUB', 'Subaru'],
            ['SUZ', 'Suzuki'],
            ['CHE', 'Chevrolet'],
            ['FOR', 'Ford'],
            ['VW',  'Volkswagen'],
            ['REN', 'Renault'],
            ['PEU', 'Peugeot'],
            ['CIT', 'Citroën'],
            ['FIA', 'Fiat'],
            ['JEE', 'Jeep'],
            ['DOD', 'Dodge'],
            ['RAM', 'RAM'],
            ['BMW', 'BMW'],
            ['MB',  'Mercedes-Benz'],
            ['AUD', 'Audi'],
            ['POR', 'Porsche'],
            ['TES', 'Tesla'],
            ['BYD', 'BYD'],
            ['CHA', 'Chery'],
            ['GEE', 'Geely'],
            ['JAC', 'JAC'],
            ['DFSK','DFSK'],
            ['MG',  'MG'],
            ['LAN', 'Land Rover'],
            ['JAG', 'Jaguar'],
            ['LEX', 'Lexus'],
            ['VOL', 'Volvo'],
            ['SKO', 'Škoda'],
            ['SEA', 'SEAT'],
            ['OPE', 'Opel'],

            // --- Camiones / buses / pesados ---
            ['ISU', 'Isuzu'],
            ['HIN', 'Hino'],
            ['FUS', 'FUSO (Mitsubishi)'],
            ['IVE', 'Iveco'],
            ['MAN', 'MAN'],
            ['SCA', 'Scania'],
            ['DAF', 'DAF'],
            ['FRE', 'Freightliner'],
            ['INT', 'International'],
            ['KEN', 'Kenworth'],
            ['PET', 'Peterbilt'],
            ['VTR', 'Volvo Trucks'],
            ['MAC', 'Mack'],
            ['TAT', 'Tata Motors'],
            ['ASH', 'Ashok Leyland'],
            ['YUT', 'Yutong'],

            // --- Maquinaria amarilla / construcción ---
            ['CAT', 'Caterpillar'],
            ['KOM', 'Komatsu'],
            ['VCE', 'Volvo Construction Equipment'],
            ['HIT', 'Hitachi Construction Machinery'],
            ['JCB', 'JCB'],
            ['LIE', 'Liebherr'],
            ['DOO', 'Doosan'],
            ['HCE', 'Hyundai Construction Equipment'],
            ['SNY', 'SANY'],
            ['XCM', 'XCMG'],
            ['LIG', 'LiuGong'],
            ['CAS', 'CASE Construction Equipment'],
            ['JDE', 'John Deere'],
            ['NHC', 'New Holland Construction'],
            ['BOB', 'Bobcat'],
            ['KOB', 'Kobelco'],
            ['TAK', 'Takeuchi'],
            ['YAN', 'Yanmar'],
            ['MANI','Manitou'],
            ['TER', 'Terex'],
            ['WNE', 'Wacker Neuson'],
            ['SDLG','SDLG'],
            ['SEM', 'SEM'],
            ['HAM', 'Hamm'],
            ['BOM', 'BOMAG'],
            ['DYN', 'Dynapac'],

            // --- Montacargas / industrial / energía ---
            ['TOYF','Toyota Material Handling (Montacargas)'],
            ['HYS', 'Hyster'],
            ['YAL', 'Yale'],
            ['JUNF','Jungheinrich'],
            ['LIN', 'Linde'],
            ['CLA', 'Clark'],
            ['KAL', 'Kalmar'],
            ['GEN', 'Generac'],
            ['CUM', 'Cummins'],
            ['PERK','Perkins'],
            ['DEU', 'DEUTZ'],
        ];

        foreach ($marcas as [$codigo, $marca]) {
            DB::table('marcas')->updateOrInsert(
                ['codigo' => $codigo],
                [
                    'marca'      => $marca,
                    'codigo'     => $codigo,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}
