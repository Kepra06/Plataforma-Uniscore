<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar las migraciones.
     */
    public function up(): void
    {
        Schema::table('partidos', function (Blueprint $table) {
            // Agregar la columna 'ganador_id' con una clave foránea
            $table->foreignId('ganador_id')->nullable()->constrained('equipos');
            
            // Incluir todas las rondas en el enum
            $table->enum('ronda', [
                'Primera Ronda',
                'Octavos de Final', 
                'Cuartos de Final', 
                'Semifinales', 
                'Final'
            ])->nullable();
        });
    }
    
    /**
     * Revertir las migraciones.
     */
    public function down(): void
    {
        Schema::table('partidos', function (Blueprint $table) {
            // Eliminar la columna 'ganador_id' y 'ronda'
            $table->dropForeign(['ganador_id']);
            $table->dropColumn('ganador_id');
            $table->dropColumn('ronda');
        });
    }
};
