<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Deconnexion — revoque le token Sanctum actuel.
 *
 * POST /api/auth/deconnexion
 * Header requis : Authorization: Bearer {token}
 *
 * Seul le token utilise pour cette requete est supprime.
 * Les autres tokens de cet utilisateur (autres appareils) restent valides.
 */
class DeconnexionController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        // Revoquer uniquement le token courant
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Deconnexion reussie.',
        ]);
    }
}
