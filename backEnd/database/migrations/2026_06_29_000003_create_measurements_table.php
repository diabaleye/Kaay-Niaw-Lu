<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('cou')->nullable();
            $table->unsignedSmallInteger('poitrine')->nullable();
            $table->unsignedSmallInteger('bras')->nullable();
            $table->unsignedSmallInteger('taille')->nullable();
            $table->unsignedSmallInteger('epaule')->nullable();
            $table->unsignedSmallInteger('hanches')->nullable();
            $table->unsignedSmallInteger('jambes')->nullable();
            $table->unsignedSmallInteger('cuisses')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('measurements');
    }
};
