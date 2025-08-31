<?php

namespace Database\Factories;

use App\Models\Locataire;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocataireFactory extends Factory
{
    protected $model = Locataire::class;

    public function definition(): array
    {
        return [
            'profession' => $this->faker->jobTitle(),
            'etatCivil' => $this->faker->randomElement(['Marié', 'Célibataire', 'Divorcé']),
            'pieceIdentite' => $this->faker->uuid(),
        ];
    }
}
