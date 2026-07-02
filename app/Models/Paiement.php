<?php

namespace App\Models;

use App\Enums\FournisseurPaiement;
use App\Enums\StatutPaiement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande_id',
        'fournisseur',
        'reference_transaction',
        'statut',
        'montant',
        'webhook_payload',
        'confirme_le',
    ];

    protected function casts(): array
    {
        return [
            'fournisseur'     => FournisseurPaiement::class,
            'statut'          => StatutPaiement::class,
            'montant'         => 'decimal:2',
            'webhook_payload' => 'array',
            'confirme_le'     => 'datetime',
        ];
    }

    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class);
    }

    public function estConfirme(): bool
    {
        return $this->statut === StatutPaiement::Confirme;
    }
}
