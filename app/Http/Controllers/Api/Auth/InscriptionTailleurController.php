<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enums\RoleUtilisateur;
use App\Enums\StatutValidationTailleur;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\InscriptionTailleurRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/**
 * Inscription d un nouveau tailleur.
 *
 * POST /api/auth/inscription/tailleur
 *
 * Flux :
 *   1. Valider les donnees (InscriptionTailleurRequest)
 *   2. Creer l utilisateur avec role = tailleur
 *   3. Creer le tailleur_profile (statut_validation = 'en_attente')
 *   4. Generer un token Sanctum
 *   5. Retourner user + token
 *
 * NOTE IMPORTANTE : le compte tailleur est cree avec statut 'en_attente'.
 * Un administrateur doit le valider avant que le tailleur soit visible
 * dans le catalogue public. C est un choix delibere pour eviter les
 * faux comptes tailleurs.
 */
class InscriptionTailleurController extends Controller
{
    public function __invoke(InscriptionTailleurRequest $request): JsonResponse
    {
        $user = DB::transaction(function () use ($request): User {

            $nomComplet = trim($request->prenom . ' ' . $request->nom);

            $user = User::create([
                'nom'       => $nomComplet,
                'email'     => $request->email,
                'telephone' => $request->telephone,
                'password'  => $request->password,
                'role'      => RoleUtilisateur::Tailleur,
            ]);

            $user->tailleurProfile()->create([
                'nom_atelier'           => $request->nom_atelier,
                'ville'                 => null, // a completer dans les parametres
                'localisation'          => $request->localisation,
                'specialites'           => $request->specialites,
                'commandes_max_semaine' => $request->commandes_max_semaine,
                'delai_moyen_jours'     => $request->delai_moyen_jours,
                'statut_validation'     => StatutValidationTailleur::EnAttente,
                'note_moyenne'          => 0.00,
                'nombre_avis'           => 0,
            ]);

            return $user->load('tailleurProfile');
        });

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Inscription reussie. Votre compte est en attente de validation par un administrateur.',
            'token'   => $token,
            'user'    => new UserResource($user),
        ], 201);
    }
}
