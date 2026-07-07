<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function tailorOrders(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->attributes->get('auth_user');

        $orders = Order::with('client')
            ->where('tailor_id', $user->id)
            ->latest()
            ->get()
            ->map(fn (Order $o) => [
                'id' => $o->id,
                'reference' => $o->reference,
                'client_name' => $o->client?->name ?? 'Client',
                'fabric_type' => $o->fabric_type,
                'progress' => $o->progress,
                'status' => $o->status,
            ]);

        return response()->json($orders);
    }

    public function clientOrders(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->attributes->get('auth_user');

        $orders = Order::with('tailor')
            ->where('client_id', $user->id)
            ->latest()
            ->get()
            ->map(fn (Order $o) => [
                'id' => $o->id,
                'reference' => $o->reference,
                'tailor_name' => strtoupper($o->tailor?->name ?? 'Tailleur'),
                'fabric_type' => $o->fabric_type,
                'deadline' => $o->deadline?->format('d/m/Y') ?? '',
                'status' => strtoupper(str_replace('_', ' ', $o->status)),
            ]);

        return response()->json($orders);
    }

    public function store(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->attributes->get('auth_user');

        $validated = $request->validate([
            'tailor_id' => 'required|exists:users,id',
            'fabric_type' => 'required|string|max:100',
            'deadline' => 'nullable|date',
        ]);

        $reference = '#CMD-'.now()->format('Y').'-'.str_pad((string) (Order::count() + 1), 4, '0', STR_PAD_LEFT);

        $order = Order::create([
            'reference' => $reference,
            'client_id' => $user->id,
            'tailor_id' => $validated['tailor_id'],
            'fabric_type' => $validated['fabric_type'],
            'progress' => 0,
            'status' => 'en_attente',
            'deadline' => $validated['deadline'] ?? now()->addDays(14)->toDateString(),
        ]);

        return response()->json([
            'message' => 'Commande créée avec succès',
            'order' => [
                'id' => $order->id,
                'reference' => $order->reference,
                'fabric_type' => $order->fabric_type,
                'status' => $order->status,
            ],
        ], 201);
    }

    public function updateStatus(Request $request, int $id): JsonResponse
    {
        /** @var User $user */
        $user = $request->attributes->get('auth_user');

        $validated = $request->validate([
            'status' => 'required|in:en_attente,a_confectionner,en_cours,pret,livree',
            'progress' => 'nullable|integer|min:0|max:100',
        ]);

        $order = Order::where('tailor_id', $user->id)->findOrFail($id);
        $order->update($validated);

        return response()->json([
            'message' => 'Commande mise à jour',
            'order' => [
                'id' => $order->id,
                'status' => $order->status,
                'progress' => $order->progress,
            ],
        ]);
    }
}
