<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parcelles', function (Blueprint $table) {
            $table->id();

            // info bailleur
            $table->foreignId('bailleur_id')->constrained('bailleurs')->onDelete('cascade');

            // General info
            $table->string('name');
            $table->string('address');
            $table->decimal('area', 10, 2)->nullable();
            $table->text('internal_rules')->nullable();

            // Legal / cadastral info
            $table->string('cadastral_number')->unique()->nullable();
            $table->string('land_title_number')->unique()->nullable();
            $table->date('land_title_date')->nullable();
            $table->enum('legal_status', ['registered', 'customary', 'state'])->nullable();

            // Building info
            $table->integer('housing_units')->default(0);
            $table->integer('floors')->nullable();
            $table->year('construction_year')->nullable();
            $table->enum('urban_zone', [
                'residential',
                'commercial',
                'industrial',
                'mixed',
                'agricultural',
                'protected'
            ])->nullable();

            // Divers
            $table->text('note')->nullable();
            $table->enum('state', ['active', 'blocked', 'pending'])->default('active');


            // Unicité du nom par bailleur
            $table->unique(['bailleur_id', 'name']);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parcelles');
    }
};
