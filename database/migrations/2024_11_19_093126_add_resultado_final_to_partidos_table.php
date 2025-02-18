<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('partidos', function (Blueprint $table) {
            $table->string('resultado_final')->nullable()->after('ganador_id'); // Almacena el resultado final en formato "X-Y"
            $table->boolean('es_empate')->default(false)->after('resultado_final'); // Campo adicional para identificar empates
        });
    }

    public function down(): void {
        Schema::table('partidos', function (Blueprint $table) {
            $table->dropColumn('resultado_final');
            $table->dropColumn('es_empate');
        });
    }
};
