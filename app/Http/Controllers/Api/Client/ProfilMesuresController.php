<?php
namespace App\Http\Controllers\Api\Client;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProfilMesuresResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfilMesuresController extends Controller {
    public function show(Request $request): JsonResponse {
        $profil = $request->user()->profilMesures
            ?? $request->user()->profilMesures()->create(['client_id' => $request->user()->id]);
        return response()->json([
            'nom'    => explode(' ', $request->user()->nom)[0],
            'profil' => new ProfilMesuresResource($profil),
        ]);
    }

    public function update(Request $request): JsonResponse {
        $v = $request->validate([
            'tour_cou'        => ['nullable','numeric','min:0','max:300'],
            'tour_poitrine'   => ['nullable','numeric','min:0','max:300'],
            'longueur_bras'   => ['nullable','numeric','min:0','max:300'],
            'tour_taille'     => ['nullable','numeric','min:0','max:300'],
            'epaule'          => ['nullable','numeric','min:0','max:300'],
            'hanches'         => ['nullable','numeric','min:0','max:300'],
            'longueur_jambes' => ['nullable','numeric','min:0','max:300'],
            'tour_cuisses'    => ['nullable','numeric','min:0','max:300'],
        ]);
        $profil = $request->user()->profilMesures
            ?? $request->user()->profilMesures()->create(['client_id' => $request->user()->id]);
        $profil->update(array_merge($v, ['mis_a_jour_le' => now()]));
        return response()->json(['message' => 'Mesures mises a jour.', 'profil' => new ProfilMesuresResource($profil->fresh())]);
    }
}
