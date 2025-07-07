<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('curso_profesor', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('estado')->default('activo');
            $table->foreignId('curso_ciclo_id')->constrained('curso_ciclo');
            $table->foreignId('profesor_id')->constrained('profesores');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curso_profesor');
    }
};
