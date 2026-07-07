<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->attributes->get('auth_user');

        $query = Conversation::with(['client', 'tailor', 'order'])
            ->when($user->role === 'client', fn ($q) => $q->where('client_id', $user->id))
            ->when($user->role === 'tailleur', fn ($q) => $q->where('tailor_id', $user->id))
            ->orderByDesc('updated_at');

        $conversations = $query->get()->map(function (Conversation $conv) use ($user) {
            $partner = $user->role === 'client' ? $conv->tailor : $conv->client;

            return [
                'id' => $conv->id,
                'name' => $partner?->name ?? 'Utilisateur',
                'lastMessage' => $conv->last_message ?? '',
                'subject' => $conv->subject ?? ($conv->order?->reference ? 'Commande '.$conv->order->reference : 'Discussion'),
                'order_reference' => $conv->order?->reference,
            ];
        });

        return response()->json(['conversations' => $conversations]);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        /** @var User $user */
        $user = $request->attributes->get('auth_user');

        $conversation = Conversation::with(['client', 'tailor', 'order'])
            ->where('id', $id)
            ->when($user->role === 'client', fn ($q) => $q->where('client_id', $user->id))
            ->when($user->role === 'tailleur', fn ($q) => $q->where('tailor_id', $user->id))
            ->firstOrFail();

        $messages = $conversation->messages()->with('sender')->orderBy('created_at')->get()->map(fn (Message $m) => [
            'id' => $m->id,
            'text' => $m->body,
            'outgoing' => $m->sender_id === $user->id,
            'created_at' => $m->created_at?->format('H:i'),
        ]);

        $partner = $user->role === 'client' ? $conversation->tailor : $conversation->client;

        return response()->json([
            'conversation' => [
                'id' => $conversation->id,
                'name' => $partner?->name ?? 'Utilisateur',
                'subject' => $conversation->subject ?? ($conversation->order?->reference ? 'Commande '.$conversation->order->reference : 'Discussion'),
                'order_reference' => $conversation->order?->reference,
            ],
            'messages' => $messages,
        ]);
    }

    public function store(Request $request, int $id): JsonResponse
    {
        /** @var User $user */
        $user = $request->attributes->get('auth_user');

        $validated = $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        $conversation = Conversation::query()
            ->where('id', $id)
            ->when($user->role === 'client', fn ($q) => $q->where('client_id', $user->id))
            ->when($user->role === 'tailleur', fn ($q) => $q->where('tailor_id', $user->id))
            ->firstOrFail();

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'body' => $validated['body'],
        ]);

        $conversation->update([
            'last_message' => $validated['body'],
        ]);

        return response()->json([
            'message' => [
                'id' => $message->id,
                'text' => $message->body,
                'outgoing' => true,
                'created_at' => $message->created_at?->format('H:i'),
            ],
        ], 201);
    }
}
