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
        Schema::create('curso_ciclo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('estado')->default('activo');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->foreignId('curso_id')->constrained('cursos');
            $table->foreignId('ciclo_id')->constrained('ciclos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curso_ciclo');
    }
};
