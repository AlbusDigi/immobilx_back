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
            // Crée 5 logements par parcelle via la factory
            Logement::factory()->count(5)->create([
                'parcelle_id' => $parcelle->id, // lie chaque logement à la parcelle
            ]);
        }

        $this->command->info('Logements générés pour toutes les parcelles existantes !');
    }
}
