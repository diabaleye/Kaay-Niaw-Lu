<?php
namespace App\Http\Controllers\Api\Client;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommandeResource;
use App\Models\Commande;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommandeClientController extends Controller {
    public function index(Request $request): JsonResponse {
        $commandes = $request->user()
            ->commandesPassees()
            ->with(['tailleur.tailleurProfile','modele'])
            ->latest()->get();
        return response()->json(['commandes' => CommandeResource::collection($commandes)]);
    }

    public function show(Request $request, Commande $commande): JsonResponse {
        if ($commande->client_id !== $request->user()->id)
            return response()->json(['message' => 'Non autorise.'], 403);
        $commande->load(['tailleur.tailleurProfile','modele','mensuration']);
        return response()->json(['commande' => new CommandeResource($commande)]);
    }
}
