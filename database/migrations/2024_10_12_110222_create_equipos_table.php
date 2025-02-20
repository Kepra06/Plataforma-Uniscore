<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('torneo_id')->constrained()->cascadeOnDelete();
            $table->enum('grupo', [
                'A', 
                'B'
            ])->nullable();            $table->string('coach')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('equipos');
    }
};
