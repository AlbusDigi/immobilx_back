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
        Schema::table('locataires', function (Blueprint $table) {
            // Renommer les champs existants pour correspondre au modèle
            $table->renameColumn('etatCivil', 'marital_status');
            $table->renameColumn('pieceIdentite', 'identity_document');
            
            // Ajouter les nouveaux champs
            $table->text('residence_address')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->date('document_issued_date')->nullable();
            $table->string('document_issued_by')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->string('guarantor_name')->nullable();
            $table->string('guarantor_phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('locataires', function (Blueprint $table) {
            // Inverser le renommage
            $table->renameColumn('marital_status', 'etatCivil');
            $table->renameColumn('identity_document', 'pieceIdentite');
            
            // Supprimer les champs ajoutés
            $table->dropColumn([
                'residence_address',
                'date_of_birth',
                'place_of_birth',
                'document_issued_date',
                'document_issued_by',
                'emergency_phone',
                'guarantor_name',
                'guarantor_phone'
            ]);
        });
    }
};