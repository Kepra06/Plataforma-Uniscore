<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('estadisticas_equipo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipo_id')->constrained('equipos')->onDelete('cascade');
            $table->foreignId('partido_id')->constrained('partidos')->onDelete('cascade');
            // Almacena el total de goles (suma de los goles de todos los jugadores del equipo en el partido)
            $table->integer('total_goals')->default(0);
            // Puedes agregar otros campos agregados si los requieres (por ejemplo, total de tarjetas amarillas o rojas)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estadisticas_equipo');
    }
};
