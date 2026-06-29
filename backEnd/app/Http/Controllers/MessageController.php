<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    // Liste toutes les conversations de l'utilisateur connecté
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $conversations = Conversation::where('artisan_id', $userId)
            ->orWhere('client_id', $userId)
            ->with(['artisan', 'client', 'dernierMessage'])
            ->orderByDesc('updated_at')
            ->get();

        return response()->json($conversations);
    }

    // Récupère tous les messages d'une conversation précise
    public function show($conversationId)
    {
        $conversation = Conversation::with('messages.sender')->findOrFail($conversationId);

        return response()->json($conversation);
    }

    // Envoie un nouveau message (texte et/ou fichier)
    public function store(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'contenu' => 'nullable|string',
            'fichier' => 'nullable|file|max:10240',
        ]);

        $cheminFichier = null;
        if ($request->hasFile('fichier')) {
            $cheminFichier = $request->file('fichier')->store('messages', 'public');
        }

        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'sender_id' => $request->user()->id,
            'contenu' => $request->contenu,
            'fichier_path' => $cheminFichier,
            'lu' => false,
        ]);

        $message->conversation->touch();

        return response()->json($message->load('sender'), 201);
    }

    // Marque les messages d'une conversation comme lus
    public function marquerCommeLu($conversationId, Request $request)
    {
        Message::where('conversation_id', $conversationId)
            ->where('sender_id', '!=', $request->user()->id)
            ->update(['lu' => true]);

        return response()->json(['message' => 'Messages marqués comme lus']);
    }

    // Crée une nouvelle conversation entre un artisan et un client
    public function creerConversation(Request $request)
    {
        $request->validate([
            'artisan_id' => 'required|exists:users,id',
            'client_id' => 'required|exists:users,id',
            'commande_reference' => 'nullable|string',
        ]);

        $conversation = Conversation::firstOrCreate([
            'artisan_id' => $request->artisan_id,
            'client_id' => $request->client_id,
        ], [
            'commande_reference' => $request->commande_reference,
        ]);

        return response()->json($conversation, 201);
    }
}