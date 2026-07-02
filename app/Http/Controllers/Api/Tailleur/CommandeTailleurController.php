<?php
namespace App\Http\Controllers\Api\Tailleur;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommandeResource;
use App\Models\Commande;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommandeTailleurController extends Controller {

    /** GET /api/tailleur/commandes?statut=en_cours */
    public function index(Request $request): JsonResponse {
        $q = Commande::where('tailleur_id', $request->user()->id)
            ->with(['client','modele','mensuration']);

        if ($request->has('statut')) {
            $q->where('statut', $request->statut);
        }

        $commandes = $q->latest()->get();
        return response()->json(['commandes' => CommandeResource::collection($commandes)]);
    }

    /** PATCH /api/tailleur/commandes/{commande}/statut */
    public function changerStatut(Request $request, Commande $commande): JsonResponse {
        if ($commande->tailleur_id !== $request->user()->id)
            return response()->json(['message' => 'Non autorise.'], 403);

        $v = $request->validate([
            'statut'      => ['required','string'],
            'progression' => ['nullable','integer','min:0','max:100'],
        ]);

        $commande->update($v);
        return response()->json(['message' => 'Statut mis a jour.', 'commande' => new CommandeResource($commande->fresh(['client','modele']))]);
    }
}
