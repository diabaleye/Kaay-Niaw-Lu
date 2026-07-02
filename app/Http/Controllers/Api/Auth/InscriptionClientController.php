<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enums\RoleUtilisateur;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\InscriptionClientRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/**
 * Inscription d un nouveau client.
 *
 * POST /api/auth/inscription/client
 *
 * Flux :
 *   1. Valider les donnees (InscriptionClientRequest)
 *   2. Creer l utilisateur avec role = client
 *   3. Creer le profil_mesures vide (carnet de mesures par defaut)
 *   4. Generer un token Sanctum
 *   5. Retourner user + token
 *
 * La transaction DB garantit qu en cas d erreur,
 * ni l utilisateur ni le profil ne sont crees a moitie.
 */
class InscriptionClientController extends Controller
{
    public function __invoke(InscriptionClientRequest $request): JsonResponse
    {
        $user = DB::transaction(function () use ($request): User {

            // Combiner prenom et nom en un seul champ 'nom'
            $nomComplet = trim($request->prenom . ' ' . $request->nom);

            $user = User::create([
                'nom'       => $nomComplet,
                'email'     => $request->email,
                'telephone' => $request->telephone,
                'password'  => $request->password, // hache automatiquement via le cast
                'role'      => RoleUtilisateur::Client,
            ]);

            // Creer un carnet de mesures vide (tous les champs sont null par defaut)
            $user->profilMesures()->create([
                'client_id' => $user->id,
            ]);

            return $user;
        });

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Inscription reussie.',
            'token'   => $token,
            'user'    => new UserResource($user),
        ], 201);
    }
}
