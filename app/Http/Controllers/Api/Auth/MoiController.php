<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Retourne les informations de l utilisateur connecte.
 *
 * GET /api/auth/moi
 * Header requis : Authorization: Bearer {token}
 *
 * Utilise par Angular au demarrage pour verifier si le token
 * stocke est encore valide et recuperer les infos utilisateur.
 */
class MoiController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->estTailleur()) {
            $user->load('tailleurProfile');
        }

        return response()->json([
            'user' => new UserResource($user),
        ]);
    }
}
