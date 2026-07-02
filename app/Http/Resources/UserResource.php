<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transforme un User Eloquent en JSON pour les reponses API.
 * N expose jamais le mot de passe ni le remember_token.
 */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'nom'       => $this->nom,
            'email'     => $this->email,
            'telephone' => $this->telephone,
            'role'      => $this->role->value,

            'profil_tailleur' => $this->when(
                $this->relationLoaded('tailleurProfile') && $this->tailleurProfile,
                fn () => [
                    'id'                    => $this->tailleurProfile->id,
                    'nom_atelier'           => $this->tailleurProfile->nom_atelier,
                    'ville'                 => $this->tailleurProfile->ville,
                    'localisation'          => $this->tailleurProfile->localisation,
                    'specialites'           => $this->tailleurProfile->specialites,
                    'commandes_max_semaine' => $this->tailleurProfile->commandes_max_semaine,
                    'delai_moyen_jours'     => $this->tailleurProfile->delai_moyen_jours,
                    'statut_validation'     => $this->tailleurProfile->statut_validation->value,
                    'note_moyenne'          => $this->tailleurProfile->note_moyenne,
                    'nombre_avis'           => $this->tailleurProfile->nombre_avis,
                ]
            ),

            'cree_le' => $this->created_at->toDateTimeString(),
        ];
    }
}
