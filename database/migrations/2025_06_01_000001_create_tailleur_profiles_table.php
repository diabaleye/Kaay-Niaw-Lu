<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tailleur_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->unique()
                  ->constrained()
                  ->cascadeOnDelete();
            $table->string('nom_atelier')->nullable();
            $table->string('ville')->nullable();
            $table->text('bio')->nullable();
            $table->string('localisation')->nullable();
            $table->string('specialites')->nullable();
            $table->unsignedSmallInteger('commandes_max_semaine')->default(10);
            $table->unsignedSmallInteger('delai_moyen_jours')->nullable();
            // 'en_attente' | 'valide' | 'refuse'
            $table->string('statut_validation')->default('en_attente');
            $table->decimal('note_moyenne', 3, 2)->default(0.00);
            $table->unsignedInteger('nombre_avis')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tailleur_profiles');
    }
};
