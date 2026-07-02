<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Snapshot des mesures pour une commande spécifique.
 *
 * Ces valeurs sont copiées depuis ProfilMesures au moment de la création
 * de la commande, puis peuvent être modifiées sans toucher au profil par défaut.
 *
 * Champs alignés sur ProfilMesures + champ `notes` pour remarques du tailleur.
 */
class Mensuration extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande_id',
        // Haut du corps (même noms que profil_mesures pour cohérence)
        'tour_cou',
        'tour_poitrine',
        'longueur_bras',
        'tour_taille',
        'epaule',
        // Bas du corps
        'hanches',
        'longueur_jambes',
        'tour_cuisses',
        // Notes du tailleur / ajustements spéciaux
        'notes',
    ];

    protected function casts(): array
    {
        return [
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

    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class);
    }
}
