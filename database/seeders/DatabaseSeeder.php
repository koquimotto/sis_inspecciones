<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            EmpresasSeeder::class,
            UsuariosSeeder::class,
            PaisesSeeder::class,
            RegionesSeeder::class,
            MarcasSeeder::class,
            ModelosSeeder::class,
            CategoriasSeeder::class,
            CargosSeeder::class,
            RolesSeeder::class,
        ]);
    }
}
