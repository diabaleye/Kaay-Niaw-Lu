<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('modeles', function (Blueprint $table) {
            if (!Schema::hasColumn('modeles', 'tissu'))
                $table->string('tissu')->nullable()->after('titre');
            if (!Schema::hasColumn('modeles', 'categorie'))
                $table->string('categorie')->default('autre')->after('tissu');
            if (!Schema::hasColumn('modeles', 'photo'))
                $table->string('photo')->nullable()->after('categorie');
        });
    }
    public function down(): void {
        Schema::table('modeles', function (Blueprint $table) {
            $table->dropColumn(['photo']);
        });
    }
};
