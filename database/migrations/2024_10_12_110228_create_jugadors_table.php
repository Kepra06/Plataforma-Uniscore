<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('jugadores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('equipo_id')->constrained('equipos');
            $table->integer('number')->nullable(); 
            $table->enum('position', ['Portero', 'Defensa', 'Centrocampista', 'Delantero'])->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('jugadores');
    }
};
