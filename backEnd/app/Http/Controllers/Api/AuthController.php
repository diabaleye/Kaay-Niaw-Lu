<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'prenom' => 'required|string|max:100',
            'nom' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'pseudo' => 'required|string|max:50|unique:users,pseudo',
            'telephone' => 'required|string|unique:users,telephone',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => 'required|in:client,tailleur',
            'workshop_name' => 'nullable|string|max:150',
            'location' => 'nullable|string|max:150',
            'specialties' => 'nullable|string|max:100',
            'max_orders' => 'nullable|integer',
            'avg_production_time' => 'nullable|string|max:50',
        ]);

        $user = User::create([
            'name' => $validated['prenom'].' '.$validated['nom'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'prenom' => $validated['prenom'],
            'nom' => $validated['nom'],
            'pseudo' => $validated['pseudo'],
            'telephone' => $validated['telephone'],
            'workshop_name' => $validated['workshop_name'] ?? null,
            'location' => $validated['location'] ?? null,
            'specialties' => $validated['specialties'] ?? null,
            'max_orders' => $validated['max_orders'] ?? null,
            'avg_production_time' => $validated['avg_production_time'] ?? null,
        ]);

        $user->settings()->create([
            'language' => 'fr',
            'theme' => 'clair',
            'notifications_enabled' => true,
        ]);

        return response()->json([
            'message' => 'Inscription réussie',
            'user' => $this->formatUser($user),
        ], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'telephone' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|in:client,tailleur',
        ]);

        $user = User::where('telephone', $validated['telephone'])
            ->where('role', $validated['role'])
            ->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => 'Identifiants incorrects'], 401);
        }

        return response()->json([
            'token' => 'token-'.$user->id,
            'user' => $this->formatUser($user),
        ]);
    }

    private function formatUser(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->prenom ?? explode(' ', $user->name)[0],
            'role' => $user->role,
            'email' => $user->email,
        ];
    }
}
