<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\empresas>
 */
class empresasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Genera un nombre de empresa realista (ej: "Sistemas San Marcos S.A.")
            'nombre' => $this->faker->company(),

            // Genera un nombre completo para el encargado
            'encargado'      => $this->faker->name(),

            // Opción A: Genera una URL de una imagen de marcador de posición (200x200 px)
            'foto'           => $this->faker->imageUrl(200, 200, 'business', true, 'logo'),

            // Opción B: Si prefieres simular una ruta de archivo local
            // 'logo'        => 'logos/empresa_' . $this->faker->unique()->numberBetween(1, 50) . '.png',
        ];
    }
}
