<?php

namespace Database\Factories;

use App\Models\Bailleur;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BailleurFactory extends Factory
{
    protected $model = Bailleur::class;

    public function definition(): array
    {
        $user = User::factory()->create();
        $user->assignRole('Bailleur');
        return [
            'user_id' => $user->id,
            'rccm' => $this->faker->randomNumber(8),
            'nif' => $this->faker->randomNumber(8),
        ];
    }
}
