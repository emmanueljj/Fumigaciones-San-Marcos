<?php

namespace Database\Seeders;

use App\Models\tecnicos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TecnicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        tecnicos::factory()->count(50)->create();
    }
}
