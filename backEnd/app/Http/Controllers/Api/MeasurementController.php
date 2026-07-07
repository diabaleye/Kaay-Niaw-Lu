<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Measurement;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MeasurementController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->attributes->get('auth_user');
        $measurement = $user->measurement;

        if (! $measurement) {
            return response()->json([
                'cou' => null, 'poitrine' => null, 'bras' => null, 'taille' => null,
                'epaule' => null, 'hanches' => null, 'jambes' => null, 'cuisses' => null,
                'updated_at' => null,
            ]);
        }

        return response()->json(array_merge(
            $measurement->only([
                'cou', 'poitrine', 'bras', 'taille', 'epaule', 'hanches', 'jambes', 'cuisses',
            ]),
            ['updated_at' => $measurement->updated_at?->diffForHumans()]
        ));
    }

    public function update(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->attributes->get('auth_user');

        $data = $request->validate([
            'cou' => 'nullable|integer|min:0|max:300',
            'poitrine' => 'nullable|integer|min:0|max:300',
            'bras' => 'nullable|integer|min:0|max:300',
            'taille' => 'nullable|integer|min:0|max:300',
            'epaule' => 'nullable|integer|min:0|max:300',
            'hanches' => 'nullable|integer|min:0|max:300',
            'jambes' => 'nullable|integer|min:0|max:300',
            'cuisses' => 'nullable|integer|min:0|max:300',
        ]);

        $measurement = Measurement::updateOrCreate(['user_id' => $user->id], $data);

        return response()->json([
            'message' => 'Mesures mises à jour',
            'data' => $measurement->only([
                'cou', 'poitrine', 'bras', 'taille', 'epaule', 'hanches', 'jambes', 'cuisses',
            ]),
            'updated_at' => $measurement->updated_at->diffForHumans(),
        ]);
    }
}
