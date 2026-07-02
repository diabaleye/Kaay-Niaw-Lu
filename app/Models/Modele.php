<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Modele extends Model
{
    use HasFactory;

    protected $fillable = [
        'tailleur_id', 'titre', 'tissu', 'categorie', 'photo', 'prix_base', 'actif',
    ];

    protected function casts(): array
    {
        return [
            'prix_base' => 'decimal:2',
            'actif'     => 'boolean',
        ];
    }

    public function tailleur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tailleur_id');
    }

    public function commandes(): HasMany
    {
        return $this->hasMany(Commande::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ModeleImage::class);
    }
}
