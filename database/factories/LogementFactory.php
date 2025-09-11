<?php

namespace Database\Factories;

use App\Models\Logement;
use App\Models\Parcelle;
use Illuminate\Database\Eloquent\Factories\Factory;

class LogementFactory extends Factory
{
    protected $model = Logement::class;

    public function definition(): array
    {
        return [
            // 🔗 Lien avec une parcelle
            'parcelle_id' => Parcelle::factory(),

            // Informations générales
            // 🔥 Génération d'un nom unique par parcelle
            'name' => 'Appartement ' . $this->faker->unique()->numberBetween(1, 500),
            'floor' => $this->faker->numberBetween(0, 10),
            'rooms' => $this->faker->numberBetween(1, 6),
            'living_area' => $this->faker->randomFloat(2, 20, 200),

            // Informations techniques
            'construction_year' => $this->faker->year(),
            'equipments' => $this->faker->sentence(6),

            // Informations financières
            'rent' => $this->faker->randomFloat(2, 200, 2000),
            'charges' => $this->faker->randomFloat(2, 20, 200),
            'deposit' => $this->faker->randomFloat(2, 100, 500),

            // Disponibilité et statut
            'availability' => $this->faker->randomElement(['available', 'occupied', 'maintenance']),
            'state' => $this->faker->randomElement(['active', 'blocked', 'pending']),

            // Notes & règlement
            'internal_rules' => $this->faker->sentence(10),
            'note' => $this->faker->sentence(8),

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
