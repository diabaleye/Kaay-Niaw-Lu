<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Table mensurations — snapshot par commande
|--------------------------------------------------------------------------
| Colonnes alignées sur profil_mesures (même noms) pour faciliter
| la copie lors de la création d'une commande.
|
| ⚠ À valider avec un tailleur avant mise en production.
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mensurations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')
                  ->unique()
                  ->constrained()
                  ->cascadeOnDelete();

            // Haut du corps
            $table->decimal('tour_cou',      5, 2)->nullable();
            $table->decimal('tour_poitrine', 5, 2)->nullable();
            $table->decimal('longueur_bras', 5, 2)->nullable();
            $table->decimal('tour_taille',   5, 2)->nullable();
            $table->decimal('epaule',        5, 2)->nullable();

            // Bas du corps
            $table->decimal('hanches',         5, 2)->nullable();
            $table->decimal('longueur_jambes', 5, 2)->nullable();
            $table->decimal('tour_cuisses',    5, 2)->nullable();

            // Remarques spéciales du tailleur
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensurations');
    }
};
