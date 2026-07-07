<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateApiUser
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (! $token || ! str_starts_with($token, 'token-')) {
            return response()->json(['message' => 'Non authentifié'], 401);
        }

        $userId = (int) substr($token, 6);
        $user = User::find($userId);

        if (! $user) {
            return response()->json(['message' => 'Utilisateur introuvable'], 401);
        }

        $request->attributes->set('auth_user', $user);

        return $next($request);
    }
}
