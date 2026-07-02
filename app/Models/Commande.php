<?php

namespace App\Models;

use App\Enums\StatutCommande;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'tailleur_profile_id',
        'modele_id',
        'statut',
        'prix_convenu',
        'date_livraison_souhaitee',
        'notes_client',
    ];

    protected function casts(): array
    {
        return [
            'statut' => StatutCommande::class,
            'prix_convenu' => 'decimal:2',
            'date_livraison_souhaitee' => 'date',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function tailleurProfile(): BelongsTo
    {
        return $this->belongsTo(TailleurProfile::class);
    }

    public function modele(): BelongsTo
    {
        return $this->belongsTo(Modele::class);
    }

    public function mensuration(): HasOne
    {
        return $this->hasOne(Mensuration::class);
    }

    public function avis(): HasOne
    {
        return $this->hasOne(Avis::class);
    }
}
