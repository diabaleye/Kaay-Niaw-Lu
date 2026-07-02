<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ModeleResource extends JsonResource {
    public function toArray(Request $request): array {
        return [
            'id'         => $this->id,
            'titre'      => $this->titre,
            'tissu'      => $this->tissu,
            'categorie'  => $this->categorie ?? 'autre',
            'prix_base'  => $this->prix_base,
            'actif'      => $this->actif,
            // URL publique de la photo (null si pas de photo)
            'photo_url'  => $this->photo ? Storage::url($this->photo) : null,
            'cree_le'    => $this->created_at?->format('d/m/Y'),
        ];
    }
}
