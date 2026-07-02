<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('avis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('tailleur_profile_id')->constrained()->cascadeOnDelete();
            // unique() : un avis par commande, pour empêcher les faux avis
            // d'un client qui n'a jamais commandé chez ce tailleur.
            $table->foreignId('commande_id')->unique()->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('note');
            $table->text('commentaire')->nullable();
            $table->string('statut')->default('visible');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avis');
    }
};
