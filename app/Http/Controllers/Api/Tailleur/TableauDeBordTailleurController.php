<?php
namespace App\Http\Controllers\Api\Tailleur;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TableauDeBordTailleurController extends Controller {
    public function __invoke(Request $request): JsonResponse {
        $tailleur = $request->user();
        $debut    = Carbon::now()->startOfWeek();

        $baseQ = \App\Models\Commande::where('tailleur_id', $tailleur->id);

        $enCours = (clone $baseQ)->whereNotIn('statut',['livre','annule'])->count();
        $livrees = (clone $baseQ)->where('statut','livre')->where('updated_at','>=',$debut)->count();
        $ca      = (clone $baseQ)->where('statut','livre')->where('updated_at','>=',$debut)->sum('montant_total');

        $prochaine = (clone $baseQ)
            ->whereNotIn('statut',['livre','annule'])
            ->with(['client','modele'])
            ->orderBy('deadline')
            ->first();

        $maxSemaine  = $tailleur->tailleurProfile?->commandes_max_semaine ?? 10;
        $pourcentage = $maxSemaine > 0 ? round(($enCours / $maxSemaine) * 100) : 0;

        // Prénom défensif : prendre la première partie du nom, ou "Utilisateur"
        $prenom = '';
        if ($tailleur->nom) {
            $parts = explode(' ', trim($tailleur->nom));
            $prenom = $parts[0] ?? $tailleur->nom;
        }

        return response()->json([
            'bienvenue' => $prenom ?: 'Tailleur',
            'kpis' => [
                'commandes_en_cours'    => $enCours,
                'livrees_cette_semaine' => $livrees,
                'chiffre_affaires'      => $ca,
            ],
            'fil_des_taches' => $prochaine ? [
                'id'          => $prochaine->id,
                'numero'      => $prochaine->numero,
                'client_nom'  => $prochaine->client?->nom,
                'tissu'       => $prochaine->modele?->tissu,
                'progression' => $prochaine->progression ?? 0,
                'deadline'    => $prochaine->deadline?->format('d/m/Y'),
            ] : null,
            'capacite' => [
                'commandes_actives' => $enCours,
                'commandes_max'     => $maxSemaine,
                'pourcentage'       => $pourcentage,
                'alerte'            => $pourcentage >= 80,
            ],
        ]);
    }
}
