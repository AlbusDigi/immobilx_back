<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Logement;
use App\Models\Parcelle;

class LogementSeeder extends Seeder
{
    public function run(): void
    {
        $parcelles = Parcelle::all();

        if ($parcelles->isEmpty()) {
            $this->command->info('Aucune parcelle trouvée, créez d’abord des parcelles.');
            return;
        }

        foreach ($parcelles as $parcelle) {
            for ($i = 1; $i <= 5; $i++) {
                Logement::create([
                    'parcelle_id' => $parcelle->id,
                    'name' => 'Appartement ' . ($i + rand(0, 100)), // Nom unique aléatoire
                    'floor' => rand(0, 5),
                    'rooms' => rand(1, 5),
                    'living_area' => rand(30, 150),
                    'construction_year' => rand(1990, 2025),
                    'equipments' => 'Cuisine équipée, climatisation',
                    'rent' => rand(200, 1500),
                    'charges' => rand(20, 200),
                    'deposit' => rand(200, 1500),
                    'availability' => ['available','occupied','maintenance'][rand(0,2)],
                    'state' => 'active',
                    'internal_rules' => 'Pas de bruit après 22h',
                    'note' => 'Généré automatiquement',
                ]);
            }
        }

        $this->command->info('Logements générés pour toutes les parcelles existantes !');
    }
}
