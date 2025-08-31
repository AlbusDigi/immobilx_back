<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Utilisateur;
use App\Models\Locataire;
use App\Models\Bailleur;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Assurez-vous que les rôles existent
        $adminRole = Role::findOrCreate('Administrateur');
        $bailleurRole = Role::findOrCreate('Bailleur');
        $locataireRole = Role::findOrCreate('Locataire');
        $conciergeRole = Role::findOrCreate('Concierge');

        // Création d'un administrateur
        $admin = User::factory()->create([
            'email' => 'admin@immobilx.com',
        ]);
        $admin->assignRole($adminRole);

        // Création d'un bailleur
        $bailleur = User::factory()->create([
            'email' => 'bailleur@immobilx.com',
        ]);
        $bailleur->assignRole($bailleurRole);
        Bailleur::factory()->create(['user_id' => $bailleur->id]);

        // Création d'un locataire
        $locataire = User::factory()->create([
            'email' => 'locataire@immobilx.com',
        ]);
        $locataire->assignRole($locataireRole);
        Locataire::factory()->create(['user_id' => $locataire->id]);

        // Création d'un concierge
        $concierge = User::factory()->create([
            'email' => 'concierge@immobilx.com',
        ]);
        $concierge->assignRole($conciergeRole);
    }
}
