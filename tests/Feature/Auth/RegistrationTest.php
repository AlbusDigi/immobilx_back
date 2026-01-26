<?php

test('new users can register as bailleur', function () {
    $this->seed(\Database\Seeders\RolesSeeder::class);

    $response = $this->post('/register/bailleur', [
        'name' => 'Test Bailleur',
        'email' => 'bailleur@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'telephone' => '123456789',
        'rccm' => 'RCCM-123',
        'nif' => 'NIF-123',
        'type' => 'individual',
        'address' => '123 Test St',
    ]);

    $response->assertStatus(201);
    $response->assertJsonStructure(['message', 'user', 'bailleur']);
});
