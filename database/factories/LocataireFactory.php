<?php

namespace Database\Factories;

use App\Models\Locataire;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocataireFactory extends Factory
{
    protected $model = Locataire::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // 🔥 crée automatiquement un User lié
            'profession' => $this->faker->jobTitle(),
            'marital_status' => $this->faker->randomElement(['Marié', 'Célibataire', 'Divorcé']),
            'identity_document' => $this->faker->uuid(),
        ];
    }
}
