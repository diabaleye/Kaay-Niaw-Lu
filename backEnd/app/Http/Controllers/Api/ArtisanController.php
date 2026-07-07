<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ArtisanController extends Controller
{
    public function index(): JsonResponse
    {
        $artisans = User::where('role', 'tailleur')
            ->get()
            ->map(fn (User $u) => [
                'id' => $u->id,
                'name' => $u->name,
                'workshop_name' => $u->workshop_name ?? 'Atelier '.$u->nom,
                'location' => $u->location ?? 'Dakar',
                'telephone' => $u->telephone,
            ]);

        return response()->json($artisans);
    }
}
