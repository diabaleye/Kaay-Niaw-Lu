<?php

namespace App\Http\Middleware;

use App\Enums\RoleUtilisateur;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Vérifie que l utilisateur connecte possede l un des roles attendus.
 * Usage : Route::middleware('role:client') ou 'role:client,tailleur'
 */
class EnsureRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $rolesAttendus = array_map(
            fn (string $r) => RoleUtilisateur::from($r),
            $roles
        );

        if (! in_array($request->user()?->role, $rolesAttendus, strict: true)) {
            return response()->json([
                'message' => 'Action non autorisee pour votre role.',
            ], 403);
        }

        return $next($request);
    }
}
