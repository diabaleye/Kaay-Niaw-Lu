<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ConnexionRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * Connexion par numero de telephone + mot de passe.
 *
 * POST /api/auth/connexion
 *
 * Flux :
 *   1. Valider telephone + password
 *   2. Tenter l authentification via Auth::attempt()
 *   3. Si echec : retourner 422 avec message d erreur
 *   4. Si succes : generer un token Sanctum et retourner user + token
 *
 * NOTE SUR LE ROLE :
 *   La maquette affiche des boutons radio "Je suis tailleur / Je suis client".
 *   Le role n est PAS envoye dans cette requete : il est lu depuis la base de donnees.
 *   Le frontend utilise le role retourne dans la reponse pour rediriger
 *   vers le bon tableau de bord. Cela empeche un client de se connecter
 *   en se pretendant tailleur.
 */
class ConnexionController extends Controller
{
    public function __invoke(ConnexionRequest $request): JsonResponse
    {
        $connecte = Auth::attempt([
            'telephone' => $request->telephone,
            'password'  => $request->password,
        ]);

        if (! $connecte) {
            throw ValidationException::withMessages([
                'telephone' => ['Numero de telephone ou mot de passe incorrect.'],
            ]);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Charger le profil tailleur si besoin (null pour les clients)
        if ($user->estTailleur()) {
            $user->load('tailleurProfile');
        }

        // Supprimer les anciens tokens pour eviter l accumulation
        // (une session active par utilisateur)
        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Connexion reussie.',
            'token'   => $token,
            'user'    => new UserResource($user),
        ]);
    }
}
