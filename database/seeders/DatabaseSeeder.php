<?php

namespace Database\Seeders;

use App\Models\productos;
use App\Models\User;
use App\Models\Tecnicos;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
        TecnicoSeeder::class,
        productosSeeder::class,
        empresasSeeder::class
       ]);
    }
}
