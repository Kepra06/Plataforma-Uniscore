<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('galeria', function (Blueprint $table) {
            $table->id();
            $table->string('title');  // Título de la imagen o video
            $table->text('description')->nullable();  // Descripción
            $table->string('file_path');  // Ruta del archivo (imagen o video)
            $table->enum('type', ['photo', 'video']);  // Tipo de archivo
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();  // Usuario que subió
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('galeria');
    }
};
