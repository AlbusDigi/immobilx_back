<?php

namespace Database\Factories;

use App\Models\Parcelle;
use App\Models\Bailleur;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParcelleFactory extends Factory
{
    protected $model = Parcelle::class;

    public function definition(): array
    {
        return [
            // 🔗 Lien avec un bailleur
            'bailleur_id' => Bailleur::factory(),

            // General info
            'name' => 'Parcelle ' . $this->faker->unique()->numberBetween(1, 1000),
            'address' => $this->faker->address(),
            'area' => $this->faker->randomFloat(2, 100, 10000),
            'internal_rules' => $this->faker->sentence(10),

            // Legal / cadastral info
            'cadastral_number' => $this->faker->unique()->bothify('CAD-###??'),
            'land_title_number' => $this->faker->unique()->bothify('LT-#####'),
            'land_title_date' => $this->faker->date(),
            'legal_status' => $this->faker->randomElement(['registered', 'customary', 'state']),

            // Building info
            'housing_units' => $this->faker->numberBetween(1, 20),
            'floors' => $this->faker->numberBetween(1, 10),
            'construction_year' => $this->faker->year(),
            'urban_zone' => $this->faker->randomElement(['residential','commercial','industrial','mixed','agricultural','protected']),

            // Divers
            'note' => $this->faker->sentence(8),
            'state' => $this->faker->randomElement(['active', 'blocked', 'pending']),

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
