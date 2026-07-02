<?php
namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class ProfilMesuresResource extends JsonResource {
    public function toArray(Request $request): array {
        return [
            'tour_cou'        => $this->tour_cou,
            'tour_poitrine'   => $this->tour_poitrine,
            'longueur_bras'   => $this->longueur_bras,
            'tour_taille'     => $this->tour_taille,
            'epaule'          => $this->epaule,
            'hanches'         => $this->hanches,
            'longueur_jambes' => $this->longueur_jambes,
            'tour_cuisses'    => $this->tour_cuisses,
            'mis_a_jour_le'   => $this->mis_a_jour_le?->diffForHumans(),
        ];
    }
}
