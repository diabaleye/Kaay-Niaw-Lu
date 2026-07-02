<?php

namespace App\Models;

use App\Enums\StatutValidationTailleur;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TailleurProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ville',
        'bio',
        'statut_validation',
        'note_moyenne',
        'nombre_avis',
    ];

    protected function casts(): array
    {
        return [
            'statut_validation' => StatutValidationTailleur::class,
            'note_moyenne' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function modeles(): HasMany
    {
        return $this->hasMany(Modele::class);
    }

    public function commandesRecues(): HasMany
    {
        return $this->hasMany(Commande::class);
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    public function avisRecus(): HasMany
    {
        return $this->hasMany(Avis::class);
    }

    public function estValide(): bool
    {
        return $this->statut_validation === StatutValidationTailleur::Valide;
    }
}
