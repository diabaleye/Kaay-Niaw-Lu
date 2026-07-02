<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Table users — point d'entrée unique pour les 3 rôles
|--------------------------------------------------------------------------
| Authentification : Sanctum en mode Bearer token (pas SPA/cookie)
| car Angular et Laravel auront des domaines différents en production.
|
| ⚠ telephone est un string, pas un int :
|   - peut commencer par 0
|   - peut contenir +221
|   - jamais utilisé en arithmétique
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            // enum géré en PHP via RoleUtilisateur, stocké en varchar
            $table->string('role')->default('client');
            $table->string('telephone')->nullable()->unique();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
    }
};
