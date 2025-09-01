<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Bailleur;
use App\Models\Locataire;
use App\Models\Concierge;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
        $admin = User::create([
            'name' => 'Admin ImmobilX',
            'email' => 'admin@immobilx.com',
            'password' => Hash::make('password123'),
            'telephone' => '+33123456780',
        ]);
        $admin->assignRole($adminRole);

        // Création d'un bailleur
        $bailleurUser = User::create([
            'name' => 'Jean Dupont',
            'email' => 'bailleur@immobilx.com',
            'password' => Hash::make('password123'),
            'telephone' => '+33123456789',
        ]);
        $bailleurUser->assignRole($bailleurRole);
        
        Bailleur::create([
            'user_id' => $bailleurUser->id,
            'rccm' => 'RC123456789',
            'nif' => 'NIF123456789',
            'type' => 'individual',
            'address' => '123 Avenue des Champs-Élysées, Paris',
            'description' => 'Propriétaire de plusieurs immeubles à Paris',
            'legal_name' => 'Dupont Properties',
            'head_office_address' => '123 Avenue des Champs-Élysées, Paris',
            'legal_form' => 'SARL',
            'registration_date' => '2020-01-15',
            'legal_contact' => 'Maître Martin, Notaire',
            'property_insurance' => 'AXA Assurance Immeuble'
        ]);

        // Création d'un locataire
        $locataireUser = User::create([
            'name' => 'Marie Martin',
            'email' => 'locataire@immobilx.com',
            'password' => Hash::make('password123'),
            'telephone' => '+33787654321',
        ]);
        $locataireUser->assignRole($locataireRole);
        
        Locataire::create([
            'user_id' => $locataireUser->id,
            'profession' => 'Ingénieure informatique',
            'marital_status' => 'Célibataire',
            'residence_address' => '45 Rue de la Paix, Paris',
            'date_of_birth' => '1990-05-15',
            'place_of_birth' => 'Lyon, France',
            'identity_document' => 'Passeport français',
            'document_issued_date' => '2020-06-20',
            'document_issued_by' => 'Préfecture de Paris',
            'emergency_phone' => '+33612345678',
            'guarantor_name' => 'Pierre Martin',
            'guarantor_phone' => '+33687654321'
        ]);

        // Création d'un concierge
        $conciergeUser = User::create([
            'name' => 'Paul Durand',
            'email' => 'concierge@immobilx.com',
            'password' => Hash::make('password123'),
            'telephone' => '+33876543210',
        ]);
        $conciergeUser->assignRole($conciergeRole);
        
        Concierge::create([
            'user_id' => $conciergeUser->id,
            'residence_address' => '12 Rue du Commerce, Paris',
            'managed_housing_count' => 5,
            'salary' => 2500.00,
            'hire_date' => '2023-01-10',
            'contract_end_date' => '2025-01-10',
            'social_security_number' => '1 23 45 67 891 234',
            'contract_type' => 'CDI',
            'employment_status' => 'active'
        ]);

        // Création de quelques données supplémentaires
        $this->createAdditionalData();
    }

    private function createAdditionalData()
    {
        // Création de bailleurs supplémentaires
        for ($i = 1; $i <= 3; $i++) {
            $bailleurUser = User::create([
                'name' => "Bailleur $i",
                'email' => "bailleur$i@example.com",
                'password' => Hash::make('password123'),
                'telephone' => '+3312345678' . $i,
            ]);
            $bailleurUser->assignRole('Bailleur');
            
            Bailleur::create([
                'user_id' => $bailleurUser->id,
                'rccm' => "RC10000000$i",
                'nif' => "NIF10000000$i",
                'type' => $i % 2 == 0 ? 'individual' : 'professional',
                'address' => "$i Rue de l'Exemple, Paris",
                'description' => "Description du bailleur $i",
                'legal_name' => "Entreprise $i",
                'head_office_address' => "$i Rue du Siège, Paris",
                'legal_form' => $i % 2 == 0 ? 'SARL' : 'EURL',
                'registration_date' => '202' . $i . '-01-01',
                'legal_contact' => "Contact légal $i",
                'property_insurance' => "Assurance $i"
            ]);
        }

        // Création de locataires supplémentaires
        for ($i = 1; $i <= 5; $i++) {
            $locataireUser = User::create([
                'name' => "Locataire $i",
                'email' => "locataire$i@example.com",
                'password' => Hash::make('password123'),
                'telephone' => '+3376543210' . $i,
            ]);
            $locataireUser->assignRole('Locataire');
            
            Locataire::create([
                'user_id' => $locataireUser->id,
                'profession' => "Profession $i",
                'marital_status' => $i % 2 == 0 ? 'Célibataire' : 'Marié(e)',
                'residence_address' => "$i Avenue des Locataires, Paris",
                'date_of_birth' => '199' . $i . '-0' . $i . '-1' . $i,
                'place_of_birth' => "Ville $i, France",
                'identity_document' => "Carte d'identité $i",
                'document_issued_date' => '202' . $i . '-0' . $i . '-1' . $i,
                'document_issued_by' => "Préfecture $i",
                'emergency_phone' => '+3361234500' . $i,
                'guarantor_name' => "Garant $i",
                'guarantor_phone' => '+3365432100' . $i
            ]);
        }

        // Création de concierges supplémentaires
        for ($i = 1; $i <= 2; $i++) {
            $conciergeUser = User::create([
                'name' => "Concierge $i",
                'email' => "concierge$i@example.com",
                'password' => Hash::make('password123'),
                'telephone' => '+3387654300' . $i,
            ]);
            $conciergeUser->assignRole('Concierge');
            
            Concierge::create([
                'user_id' => $conciergeUser->id,
                'residence_address' => "$i Rue des Concierges, Paris",
                'managed_housing_count' => $i * 3,
                'salary' => 2000.00 + ($i * 200),
                'hire_date' => '202' . $i . '-03-1' . $i,
                'contract_end_date' => '202' . ($i + 3) . '-03-1' . $i,
                'social_security_number' => "$i 23 45 67 891 23$i",
                'contract_type' => $i % 2 == 0 ? 'CDI' : 'CDD',
                'employment_status' => 'active'
            ]);
        }
    }
}