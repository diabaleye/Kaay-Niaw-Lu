<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('tailleur_profile_id')->constrained()->cascadeOnDelete();
            // Nullable : une commande peut être une création sur-mesure
            // qui ne part pas d'un modèle déjà publié au catalogue.
            $table->foreignId('modele_id')->nullable()->constrained()->nullOnDelete();
            $table->string('statut')->default('en_attente');
            $table->decimal('prix_convenu', 10, 2)->nullable();
            $table->date('date_livraison_souhaitee')->nullable();
            $table->text('notes_client')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
