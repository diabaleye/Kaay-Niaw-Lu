<?php
namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class CommandeResource extends JsonResource {
    public function toArray(Request $request): array {
        return [
            'id'          => $this->id,
            'numero'      => $this->numero,
            'statut'      => $this->statut instanceof \BackedEnum ? $this->statut->value : $this->statut,
            'progression' => $this->progression ?? 0,
            'deadline'    => $this->deadline?->format('d/m/Y'),
            'montant'     => $this->montant_total,
            'client'  => $this->whenLoaded('client',  fn() => ['id' => $this->client->id,  'nom' => $this->client->nom]),
            'tailleur'=> $this->whenLoaded('tailleur', fn() => [
                'id' => $this->tailleur->id,
                'nom' => $this->tailleur->nom,
                'nom_atelier' => $this->tailleur->tailleurProfile?->nom_atelier,
            ]),
            'modele'  => $this->whenLoaded('modele',  fn() => [
                'titre' => $this->modele->titre,
                'tissu' => $this->modele->tissu,
                'prix_base' => $this->modele->prix_base,
            ]),
        ];
    }
}
