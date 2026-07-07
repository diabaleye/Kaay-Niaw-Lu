<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Modele;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ModeleController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        /** @var User|null $user */
        $user = $request->attributes->get('auth_user');

        $query = Modele::query();

        if ($user && $user->role === 'tailleur') {
            $query->where('tailor_id', $user->id);
        }

        if ($category = $request->query('category')) {
            $categoryMap = [
                'Grands boubous' => 'grands_boubous',
                'Kaftans et robes' => 'kaftans_robes',
                'Tuniques modernes' => 'tuniques_modernes',
            ];
            $query->where('category', $categoryMap[$category] ?? $category);
        }

        $modeles = $query->get()->map(fn (Modele $m) => [
            'id' => $m->id,
            'name' => $m->name,
            'fabric' => $m->fabric,
            'price' => $m->price,
            'category' => $m->category,
        ]);

        return response()->json($modeles);
    }

    public function store(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->attributes->get('auth_user');

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'fabric' => 'required|string|max:100',
            'price' => 'required|integer|min:0',
            'category' => 'required|in:grands_boubous,kaftans_robes,tuniques_modernes',
        ]);

        $modele = Modele::create([
            ...$validated,
            'tailor_id' => $user->id,
        ]);

        return response()->json([
            'message' => 'Modèle ajouté',
            'modele' => [
                'id' => $modele->id,
                'name' => $modele->name,
                'fabric' => $modele->fabric,
                'price' => $modele->price,
                'category' => $modele->category,
            ],
        ], 201);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        /** @var User $user */
        $user = $request->attributes->get('auth_user');

        $modele = Modele::where('tailor_id', $user->id)->findOrFail($id);
        $modele->delete();

        return response()->json(['message' => 'Modèle supprimé']);
    }
}
