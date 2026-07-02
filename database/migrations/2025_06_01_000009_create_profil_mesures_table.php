<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Table profil_mesures — Carnet de mesures par défaut du client
|--------------------------------------------------------------------------
| Distinct de la table `mensurations` qui est un snapshot par commande.
| Champs validés depuis la maquette Figma "Carnet de mesures" (image 11) :
| Cou, Tour de Poitrine, Longueur Bras, Tour de Taille, Épaule,
| Hanches, Longueur Jambes, Tour de Cuisses.
|
| ⚠ À valider avec un tailleur professionnel avant mise en prod :
|   ces noms/unités sont extraits de la maquette, pas d'une expertise métier.
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_mesures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')
                  ->unique()
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Haut du corps
            $table->decimal('tour_cou',      5, 2)->nullable();
            $table->decimal('tour_poitrine', 5, 2)->nullable();
            $table->decimal('longueur_bras', 5, 2)->nullable();
            $table->decimal('tour_taille',   5, 2)->nullable();
            $table->decimal('epaule',        5, 2)->nullable();

            // Bas du corps
            $table->decimal('hanches',          5, 2)->nullable();
            $table->decimal('longueur_jambes',  5, 2)->nullable();
            $table->decimal('tour_cuisses',     5, 2)->nullable();

            $table->timestamp('mis_a_jour_le')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_mesures');
    }
};
