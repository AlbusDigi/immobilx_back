<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'Administrateur']);
        Role::create(['name' => 'Bailleur']);
        Role::create(['name' => 'Locataire']);
        Role::create(['name' => 'Concierge']);
    }
}