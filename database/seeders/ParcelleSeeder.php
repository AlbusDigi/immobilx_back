<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parcelle;
use App\Models\Bailleur;
use Illuminate\Support\Str;

class ParcelleSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer tous les bailleurs existants
        $bailleurs = Bailleur::all()->pluck('id')->toArray();

        if (empty($bailleurs)) {
            $this->command->info('Aucun bailleur trouvé, veuillez en créer avant.');
            return;
        }

        for ($i = 1; $i <= 5; $i++) {
            Parcelle::create([
                'bailleur_id' => $bailleurs[array_rand($bailleurs)],
                'name' => 'Parcelle ' . $i,
                'address' => $i . ' Rue Principale, Abidjan',
                'area' => rand(500, 2000),
                'internal_rules' => 'Pas de bruit après 22h',
                'cadastral_number' => 'CAD' . rand(10000, 99999),
                'land_title_number' => 'TF' . rand(10000, 99999),
                'land_title_date' => now()->subYears(rand(1, 10))->format('Y-m-d'),
                'legal_status' => ['registered', 'customary', 'state'][rand(0,2)],
                'housing_units' => rand(1, 10),
                'floors' => rand(1, 5),
                'construction_year' => rand(1990, 2025),
                'urban_zone' => ['residential','commercial','industrial','mixed','agricultural','protected'][rand(0,5)],
                'note' => 'Parcelle générée automatiquement',
                'status' => 'active',
            ]);
        }

        $this->command->info('5 parcelles créées avec succès !');
    }
}
