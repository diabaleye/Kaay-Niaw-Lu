<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->attributes->get('auth_user');
        $settings = UserSetting::firstOrCreate(
            ['user_id' => $user->id],
            ['language' => 'fr', 'theme' => 'clair', 'notifications_enabled' => true]
        );

        return response()->json([
            'profile' => $this->formatProfile($user),
            'settings' => [
                'language' => $settings->language,
                'theme' => $settings->theme,
                'notifications_enabled' => $settings->notifications_enabled,
            ],
        ]);
    }

    public function updateProfile(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->attributes->get('auth_user');

        $validated = $request->validate([
            'prenom' => 'sometimes|string|max:100',
            'nom' => 'sometimes|string|max:100',
            'email' => 'sometimes|email|unique:users,email,'.$user->id,
            'telephone' => 'sometimes|string|unique:users,telephone,'.$user->id,
            'workshop_name' => 'nullable|string|max:150',
            'location' => 'nullable|string|max:150',
            'specialties' => 'nullable|string|max:100',
        ]);

        if (isset($validated['prenom']) || isset($validated['nom'])) {
            $validated['name'] = ($validated['prenom'] ?? $user->prenom).' '.($validated['nom'] ?? $user->nom);
        }

        $user->update($validated);

        return response()->json([
            'message' => 'Profil mis à jour',
            'profile' => $this->formatProfile($user->fresh()),
        ]);
    }

    public function updatePreferences(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->attributes->get('auth_user');

        $validated = $request->validate([
            'language' => 'sometimes|in:fr,en,wo',
            'theme' => 'sometimes|in:clair,sombre',
            'notifications_enabled' => 'sometimes|boolean',
        ]);

        $settings = UserSetting::updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return response()->json([
            'message' => 'Préférences enregistrées',
            'settings' => [
                'language' => $settings->language,
                'theme' => $settings->theme,
                'notifications_enabled' => $settings->notifications_enabled,
            ],
        ]);
    }

    public function changePassword(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->attributes->get('auth_user');

        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        if (! Hash::check($validated['current_password'], $user->password)) {
            return response()->json(['message' => 'Mot de passe actuel incorrect'], 422);
        }

        $user->update(['password' => Hash::make($validated['password'])]);

        return response()->json(['message' => 'Mot de passe modifié avec succès']);
    }

    public function destroy(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->attributes->get('auth_user');

        $validated = $request->validate([
            'password' => 'required|string',
        ]);

        if (! Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => 'Mot de passe incorrect'], 422);
        }

        $user->delete();

        return response()->json(['message' => 'Compte supprimé avec succès']);
    }

    private function formatProfile(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->prenom ?? explode(' ', $user->name)[0],
            'prenom' => $user->prenom,
            'nom' => $user->nom,
            'email' => $user->email,
            'telephone' => $user->telephone,
            'role' => $user->role,
            'workshop_name' => $user->workshop_name,
            'location' => $user->location,
            'specialties' => $user->specialties,
        ];
    }
}
