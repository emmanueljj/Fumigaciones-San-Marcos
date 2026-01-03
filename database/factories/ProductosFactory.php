<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Productos>
 */
class ProductosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
            return [
            // Nombres comerciales comunes o genéricos
            'nombre' => $this->faker->randomElement([
                'Abate', 'Deltametrina', 'Cipermetrina', 'Fipronil', 
                'Bromadiolona', 'Hydramethylnon', 'Permetrina', 'Bifentrina'
            ]),

            // Concentraciones típicas de químicos
            'concentracion' => $this->faker->randomElement([
                '1%', '2.5% CE', '5% SC', '500 SC', '0.05% Gel', 'Gánulos'
            ]),

            // Métodos de aplicación en fumigación
            'metodo' => $this->faker->randomElement([
                'Aspersión Manual', 'Nebulización en Frío', 'Termonebulización', 
                'Aplicación de Gel', 'Estaciones de Cebado', 'Espolvoreo'
            ]),

            // Plagas objetivo
            'plaga' => $this->faker->randomElement([
                'Cucarachas', 'Roedores', 'Termitas', 'Hormigas', 
                'Moscas y Mosquitos', 'Chinches de Cama', 'Arácnidos'
            ]),
        ];
    
    }
}
