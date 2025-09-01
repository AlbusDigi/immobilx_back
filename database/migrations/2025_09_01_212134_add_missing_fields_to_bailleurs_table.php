<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bailleurs', function (Blueprint $table) {
            // Ajouter les nouveaux champs
            $table->enum('type', ['individual', 'professional'])->nullable();
            $table->text('address')->nullable();
            $table->text('description')->nullable();
            $table->string('legal_name')->nullable();
            $table->text('head_office_address')->nullable();
            $table->string('legal_form')->nullable();
            $table->date('registration_date')->nullable();
            $table->string('legal_contact')->nullable();
            $table->string('property_insurance')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bailleurs', function (Blueprint $table) {
            // Inverser les changements en cas de rollback
            $table->renameColumn('nip', 'nif');
            
            $table->dropColumn([
                'type',
                'address',
                'description',
                'legal_name',
                'head_office_address',
                'legal_form',
                'registration_date',
                'legal_contact',
                'property_insurance'
            ]);
        });
    }
};
