<?php
namespace App\Http\Controllers\Api\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TableauDeBordClientController extends Controller {
    public function __invoke(Request $request): JsonResponse {
        $client = $request->user();
        $debut  = Carbon::now()->startOfWeek();
        $q      = $client->commandesPassees();

        $prenom = '';
        if ($client->nom) {
            $parts = explode(' ', trim($client->nom));
            $prenom = $parts[0] ?? $client->nom;
        }

        return response()->json([
            'bienvenue' => $prenom ?: 'Client',
            'kpis' => [
                'commandes_en_cours'    => (clone $q)->whereNotIn('statut',['livre','annule'])->count(),
                'livrees_cette_semaine' => (clone $q)->where('statut','livre')->where('updated_at','>=',$debut)->count(),
                'total_commandes'       => (clone $q)->count(),
            ],
        ]);
    }
}
