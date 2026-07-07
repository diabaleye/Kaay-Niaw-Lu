<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ArtisanController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\MeasurementController;
use App\Http\Controllers\Api\ModeleController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\CalendarController;

Route::get('/artisans', [ArtisanController::class, 'index']);
Route::post('/contact', [ContactController::class, 'store']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth.api')->group(function () {
    Route::get('/tailor/dashboard', [DashboardController::class, 'tailor']);
    Route::get('/client/dashboard', [DashboardController::class, 'client']);
    Route::get('/tailor/orders', [OrderController::class, 'tailorOrders']);
    Route::get('/client/orders', [OrderController::class, 'clientOrders']);
    Route::post('/client/orders', [OrderController::class, 'store']);
    Route::patch('/tailor/orders/{id}', [OrderController::class, 'updateStatus']);
    Route::get('/client/measurements', [MeasurementController::class, 'show']);
    Route::put('/client/measurements', [MeasurementController::class, 'update']);
    Route::get('/tailor/modeles', [ModeleController::class, 'index']);
    Route::post('/tailor/modeles', [ModeleController::class, 'store']);
    Route::delete('/tailor/modeles/{id}', [ModeleController::class, 'destroy']);
    Route::get('/tailor/calendar', [CalendarController::class, 'index']);
    Route::get('/messages', [MessageController::class, 'index']);
    Route::get('/messages/{id}', [MessageController::class, 'show']);
    Route::post('/messages/{id}', [MessageController::class, 'store']);
    Route::get('/settings', [SettingsController::class, 'show']);
    Route::put('/settings/profile', [SettingsController::class, 'updateProfile']);
    Route::put('/settings/preferences', [SettingsController::class, 'updatePreferences']);
    Route::put('/settings/password', [SettingsController::class, 'changePassword']);
    Route::delete('/settings/account', [SettingsController::class, 'destroy']);
});
