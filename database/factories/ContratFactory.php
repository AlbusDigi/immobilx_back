<?php

namespace Database\Factories;

use App\Models\Contrat;
use App\Models\Bailleur;
use App\Models\Locataire;
use App\Models\Logement;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContratFactory extends Factory
{
    protected $model = Contrat::class;

    public function definition(): array
    {
        return [
            'bailleur_id' => Bailleur::factory(),
            'locataire_id' => Locataire::factory(),
            'logement_id' => Logement::factory(),
            'dateDebut' => $this->faker->date(),
            'dateFin' => $this->faker->date('Y-m-d', '+1 year'),
            'caution' => $this->faker->randomFloat(2, 500, 2000),
            'loyerMensuel' => $this->faker->randomFloat(2, 300, 1500),
        ];
    }
}
