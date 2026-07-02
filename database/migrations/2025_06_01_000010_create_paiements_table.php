<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Table paiements
|--------------------------------------------------------------------------
| Supporte Wave et Orange Money via une couche d'abstraction
| (PaymentGatewayInterface → WavePaymentGateway | OrangeMoneyPaymentGateway).
|
| La colonne reference_transaction doit rester nullable jusqu'à confirmation
| par le webhook du fournisseur (le paiement peut être initié mais non confirmé).
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->constrained()->cascadeOnDelete();

            // 'wave' | 'orange_money'
            $table->string('fournisseur');

            // Identifiant retourné par le fournisseur (null jusqu'à initiation)
            $table->string('reference_transaction')->nullable()->unique();

            // 'en_attente' | 'confirme' | 'echoue' | 'rembourse'
            $table->string('statut')->default('en_attente');

            $table->decimal('montant', 10, 2);

            // Payload brut du webhook stocké pour audit/débogage
            $table->json('webhook_payload')->nullable();

            $table->timestamp('confirme_le')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
