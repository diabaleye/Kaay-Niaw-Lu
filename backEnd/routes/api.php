<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/conversations', [MessageController::class, 'index']);
    Route::get('/conversations/{id}', [MessageController::class, 'show']);
    Route::post('/conversations', [MessageController::class, 'creerConversation']);
    Route::post('/messages', [MessageController::class, 'store']);
    Route::post('/conversations/{id}/lu', [MessageController::class, 'marquerCommeLu']);
});