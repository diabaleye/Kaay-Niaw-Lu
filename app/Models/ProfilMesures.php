<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Carnet de mesures par défaut du client.
 *
 * Ces valeurs sont pré-remplies dans le formulaire de commande.
 * Le client peut les modifier ponctuellement sans toucher ce profil.
 * La table `mensurations` stocke le snapshot validé par commande.
 */
class ProfilMesures extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        // Haut du corps
        'tour_cou',
        'tour_poitrine',
        'longueur_bras',
        'tour_taille',
        'epaule',
        // Bas du corps
        'hanches',
        'longueur_jambes',
        'tour_cuisses',
        'mis_a_jour_le',
    ];

    protected function casts(): array
    {
        return [
            'mis_a_jour_le' => 'datetime',
            // Tous les champs numériques en float pour les calculs éventuels
            'tour_cou'        => 'float',
            'tour_poitrine'   => 'float',
            'longueur_bras'   => 'float',
            'tour_taille'     => 'float',
            'epaule'          => 'float',
            'hanches'         => 'float',
            'longueur_jambes' => 'float',
            'tour_cuisses'    => 'float',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
