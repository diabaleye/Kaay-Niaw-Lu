<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function tailor(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->attributes->get('auth_user');

        $enCours = Order::where('tailor_id', $user->id)->where('status', 'en_cours')->count();
        $livrees = Order::where('tailor_id', $user->id)->where('status', 'livree')->count();
        $totalRevenue = Order::where('tailor_id', $user->id)->where('status', 'livree')->count() * 50000;
        $maxOrders = $user->max_orders ?? 10;
        $activeOrders = Order::where('tailor_id', $user->id)->whereIn('status', ['en_attente', 'a_confectionner', 'en_cours'])->count();
        $capacity = $maxOrders > 0 ? min(100, (int) round(($activeOrders / $maxOrders) * 100)) : 0;

        return response()->json([
            'kpis' => [
                'enCours' => $enCours,
                'livrees' => $livrees,
                'ca' => $totalRevenue >= 1000 ? round($totalRevenue / 1000).'K' : (string) $totalRevenue,
            ],
            'capacity' => $capacity,
        ]);
    }

    public function client(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->attributes->get('auth_user');

        $enCours = Order::where('client_id', $user->id)->where('status', 'en_cours')->count();
        $livrees = Order::where('client_id', $user->id)->where('status', 'livree')->count();

        return response()->json([
            'kpis' => [
                'enCours' => $enCours,
                'livrees' => $livrees,
                'notifications' => Order::where('client_id', $user->id)->where('status', 'en_cours')->count(),
            ],
        ]);
    }
}
