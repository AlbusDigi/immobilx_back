<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contrat;
use App\Models\Bailleur;
use App\Models\Locataire;
use App\Models\Logement;
use App\Models\Parcelle;

class ContratSeeder extends Seeder
{
    public function run(): void
    {
        // 1️⃣ Crée un bailleur
        $bailleur = Bailleur::factory()->create();

        // 2️⃣ Crée une parcelle pour ce bailleur
        $parcelle = Parcelle::factory()->create([
            'bailleur_id' => $bailleur->id,
        ]);

        // 3️⃣ Crée un logement lié à la parcelle (pas de bailleur_id ici)
        $logement = Logement::factory()->create([
            'parcelle_id' => $parcelle->id,
        ]);

        // 4️⃣ Crée un locataire
        $locataire = Locataire::factory()->create();

        // 5️⃣ Crée 10 contrats pour ce locataire et logement
        Contrat::factory()->count(10)->create([
            'locataire_id' => $locataire->id,
            'logement_id' => $logement->id,
            'bailleur_id' => $bailleur->id, // ici, le contrat peut contenir bailleur_id
        ]);
    }
}
