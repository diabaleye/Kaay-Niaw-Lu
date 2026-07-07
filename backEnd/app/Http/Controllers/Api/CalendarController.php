<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->attributes->get('auth_user');

        $month = (int) $request->query('month', now()->month);
        $year = (int) $request->query('year', now()->year);

        $orders = Order::where('tailor_id', $user->id)
            ->whereNotNull('deadline')
            ->whereYear('deadline', $year)
            ->whereMonth('deadline', $month)
            ->get();

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $calendarDays = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $deliveries = $orders->filter(fn (Order $o) => (int) $o->deadline->format('j') === $day)->count();
            $calendarDays[] = [
                'date' => $day,
                'deliveries' => $deliveries,
            ];
        }

        $events = $orders->map(fn (Order $o) => [
            'id' => $o->id,
            'reference' => $o->reference,
            'client_name' => $o->client?->name ?? 'Client',
            'deadline' => $o->deadline->format('d/m/Y'),
            'status' => $o->status,
        ]);

        return response()->json([
            'month' => $month,
            'year' => $year,
            'calendarDays' => $calendarDays,
            'events' => $events,
        ]);
    }
}
