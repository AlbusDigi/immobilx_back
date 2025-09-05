<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logements', function (Blueprint $table) {
            $table->id();

            // Lien avec la parcelle
            $table->foreignId('parcelle_id')->constrained('parcelles')->onDelete('cascade');

            // Informations générales
            $table->string('name');
            $table->integer('floor')->nullable();
            $table->integer('rooms')->nullable();
            $table->decimal('living_area', 10, 2)->nullable();

            // Informations techniques
            $table->year('construction_year')->nullable();
            $table->text('equipments')->nullable();

            // Informations financières
            $table->decimal('rent', 10, 2)->nullable();
            $table->decimal('charges', 10, 2)->nullable();
            $table->decimal('deposit', 10, 2)->nullable();

            // Disponibilité et statut
            $table->enum('availability', ['available', 'occupied', 'maintenance'])->default('available');
            $table->enum('state', ['active', 'blocked', 'pending'])->default('active');

            // Règlement et notes propres au logement
            $table->text('internal_rules')->nullable();
            $table->text('note')->nullable();

            // Unicité : nom unique par parcelle
            $table->unique(['parcelle_id', 'name']);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logements');
    }
};
