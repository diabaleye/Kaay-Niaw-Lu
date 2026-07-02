<?php

namespace App\Models;

use App\Enums\StatutAvis;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Avis extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'tailleur_profile_id',
        'commande_id',
        'note',
        'commentaire',
        'statut',
    ];

    protected function casts(): array
    {
        return [
            'statut' => StatutAvis::class,
            'note' => 'integer',
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

    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class);
    }
}
