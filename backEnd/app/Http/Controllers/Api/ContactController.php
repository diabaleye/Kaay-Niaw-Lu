<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email',
            'message' => 'required|string|max:2000',
        ]);

        ContactMessage::create($validated);

        return response()->json(['message' => 'Message reçu avec succès'], 201);
    }
}
