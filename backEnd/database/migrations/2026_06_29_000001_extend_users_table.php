<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('client')->after('email');
            $table->string('prenom')->nullable()->after('role');
            $table->string('nom')->nullable()->after('prenom');
            $table->string('pseudo')->nullable()->after('nom');
            $table->string('telephone')->nullable()->unique()->after('pseudo');
            $table->string('workshop_name')->nullable()->after('telephone');
            $table->string('location')->nullable()->after('workshop_name');
            $table->string('specialties')->nullable()->after('location');
            $table->unsignedInteger('max_orders')->nullable()->after('specialties');
            $table->string('avg_production_time')->nullable()->after('max_orders');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role', 'prenom', 'nom', 'pseudo', 'telephone',
                'workshop_name', 'location', 'specialties', 'max_orders', 'avg_production_time'
            ]);
        });
    }
};
