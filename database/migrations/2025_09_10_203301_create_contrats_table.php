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
        Schema::create('contrats', function (Blueprint $table) {
            $table->id();

            // Clé étrangère pour le bailleur
            $table->foreignId('bailleur_id')
                ->constrained('bailleurs') // Référence la table 'bailleurs'
                ->onDelete('cascade'); // Efface les contrats si le bailleur est supprimé

            // Clé étrangère pour le locataire
            $table->foreignId('locataire_id')
                ->nullable()
                ->constrained('locataires') // Référence la table 'locataires'
                ->onDelete('set null'); // Met la clé à null si le locataire est supprimé

            // Clé étrangère pour le logement
            $table->foreignId('logement_id')
                ->constrained('logements') // Référence la table 'logements'
                ->onDelete('cascade'); // Efface les contrats si le logement est supprimé

            $table->date('dateDebut');
            $table->date('dateFin');
            $table->decimal('caution', 8, 2)->nullable();
            $table->decimal('loyerMensuel', 8, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrats');
    }
};
