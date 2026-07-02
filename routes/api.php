<?php
use App\Http\Controllers\Api\Auth\ConnexionController;
use App\Http\Controllers\Api\Auth\DeconnexionController;
use App\Http\Controllers\Api\Auth\InscriptionClientController;
use App\Http\Controllers\Api\Auth\InscriptionTailleurController;
use App\Http\Controllers\Api\Auth\MoiController;
use App\Http\Controllers\Api\Client\TableauDeBordClientController;
use App\Http\Controllers\Api\Client\ProfilMesuresController;
use App\Http\Controllers\Api\Client\CommandeClientController;
use App\Http\Controllers\Api\Tailleur\TableauDeBordTailleurController;
use App\Http\Controllers\Api\Tailleur\CommandeTailleurController;
use App\Http\Controllers\Api\Tailleur\ModeleController;
use Illuminate\Support\Facades\Route;

// ─── ROUTES PUBLIQUES ────────────────────────────────────────────────────────
Route::prefix('auth')->group(function () {
    Route::post('/inscription/client',   InscriptionClientController::class);
    Route::post('/inscription/tailleur', InscriptionTailleurController::class);
    Route::post('/connexion',            ConnexionController::class);
});

// ─── ROUTES PROTÉGÉES ────────────────────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/auth/moi',          MoiController::class);
    Route::post('/auth/deconnexion', DeconnexionController::class);

    // ── CLIENT ────────────────────────────────────────────────────────────────
    Route::middleware('role:client')->prefix('client')->group(function () {
        Route::get('/tableau-de-bord', TableauDeBordClientController::class);

        Route::get('/profil-mesures',  [ProfilMesuresController::class, 'show']);
        Route::put('/profil-mesures',  [ProfilMesuresController::class, 'update']);

        Route::get('/commandes',               [CommandeClientController::class, 'index']);
        Route::get('/commandes/{commande}',    [CommandeClientController::class, 'show']);
    });

    // ── TAILLEUR ──────────────────────────────────────────────────────────────
    Route::middleware('role:tailleur')->prefix('tailleur')->group(function () {
        Route::get('/tableau-de-bord', TableauDeBordTailleurController::class);

        Route::get('/commandes',                           [CommandeTailleurController::class, 'index']);
        Route::patch('/commandes/{commande}/statut',       [CommandeTailleurController::class, 'changerStatut']);

        Route::get('/modeles',                             [ModeleController::class, 'index']);
        Route::post('/modeles',                            [ModeleController::class, 'store']);
        Route::put('/modeles/{modele}',                    [ModeleController::class, 'update']);
        Route::patch('/modeles/{modele}/visibilite',       [ModeleController::class, 'toggleVisibilite']);
        Route::delete('/modeles/{modele}',                 [ModeleController::class, 'destroy']);
    });

    // ── ADMIN ─────────────────────────────────────────────────────────────────
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        // Phase 9 — à venir
    });
});
