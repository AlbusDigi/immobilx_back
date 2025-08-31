<?php

namespace Database\Factories;

use App\Models\Bailleur;
use Illuminate\Database\Eloquent\Factories\Factory;

class BailleurFactory extends Factory
{
    protected $model = Bailleur::class;

    public function definition(): array
    {
        return [
            'rccm' => $this->faker->randomNumber(8),
            'nif' => $this->faker->randomNumber(8),
        ];
    }
}
