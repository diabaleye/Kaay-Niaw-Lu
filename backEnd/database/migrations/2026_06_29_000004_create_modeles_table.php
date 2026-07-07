<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modeles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tailor_id')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('fabric');
            $table->unsignedInteger('price');
            $table->string('category')->default('tous');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modeles');
    }
};
