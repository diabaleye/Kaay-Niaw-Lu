<?php
namespace App\Http\Controllers\Api\Tailleur;

use App\Http\Controllers\Controller;
use App\Http\Resources\ModeleResource;
use App\Models\Modele;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModeleController extends Controller
{
    /** GET /api/tailleur/modeles?categorie=grands_boubous */
    public function index(Request $request): JsonResponse {
        $q = Modele::where('tailleur_id', $request->user()->id);
        if ($request->filled('categorie') && $request->categorie !== 'tous')
            $q->where('categorie', $request->categorie);
        return response()->json(['modeles' => ModeleResource::collection($q->latest()->get())]);
    }

    /** POST /api/tailleur/modeles (multipart/form-data) */
    public function store(Request $request): JsonResponse {
        $v = $request->validate([
            'titre'     => ['required', 'string', 'max:255'],
            'tissu'     => ['nullable', 'string', 'max:255'],
            'categorie' => ['nullable', 'string', 'in:grands_boubous,kaftans_et_robes,tuniques_modernes,autre'],
            'prix_base' => ['required', 'numeric', 'min:0'],
            'photo'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('modeles', 'public');
        }

        $modele = Modele::create([
            'tailleur_id' => $request->user()->id,
            'titre'       => $v['titre'],
            'tissu'       => $v['tissu'] ?? null,
            'categorie'   => $v['categorie'] ?? 'autre',
            'prix_base'   => $v['prix_base'],
            'photo'       => $photoPath,
            'actif'       => true,
        ]);

        return response()->json([
            'message' => 'Modele cree.',
            'modele'  => new ModeleResource($modele),
        ], 201);
    }

    /** POST /api/tailleur/modeles/{modele} avec _method=PUT (compatible multipart) */
    public function update(Request $request, Modele $modele): JsonResponse {
        if ($modele->tailleur_id !== $request->user()->id)
            return response()->json(['message' => 'Non autorise.'], 403);

        $v = $request->validate([
            'titre'     => ['required', 'string', 'max:255'],
            'tissu'     => ['nullable', 'string', 'max:255'],
            'categorie' => ['nullable', 'string', 'in:grands_boubous,kaftans_et_robes,tuniques_modernes,autre'],
            'prix_base' => ['required', 'numeric', 'min:0'],
            'photo'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
        ]);

        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo
            if ($modele->photo) Storage::disk('public')->delete($modele->photo);
            $v['photo'] = $request->file('photo')->store('modeles', 'public');
        } else {
            unset($v['photo']); // Ne pas écraser si aucune nouvelle photo
        }

        $modele->update($v);

        return response()->json([
            'message' => 'Modele mis a jour.',
            'modele'  => new ModeleResource($modele),
        ]);
    }

    /** PATCH /api/tailleur/modeles/{modele}/visibilite */
    public function toggleVisibilite(Request $request, Modele $modele): JsonResponse {
        if ($modele->tailleur_id !== $request->user()->id)
            return response()->json(['message' => 'Non autorise.'], 403);
        $modele->update(['actif' => !$modele->actif]);
        return response()->json(['actif' => $modele->actif]);
    }

    /** DELETE /api/tailleur/modeles/{modele} */
    public function destroy(Request $request, Modele $modele): JsonResponse {
        if ($modele->tailleur_id !== $request->user()->id)
            return response()->json(['message' => 'Non autorise.'], 403);
        if ($modele->photo) Storage::disk('public')->delete($modele->photo);
        $modele->delete();
        return response()->json(['message' => 'Modele supprime.']);
    }
}
