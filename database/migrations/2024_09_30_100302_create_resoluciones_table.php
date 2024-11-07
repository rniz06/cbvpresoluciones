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
        Schema::create('resoluciones', function (Blueprint $table) {
            $table->id();
            $table->string('n_resolucion')->unique();
            $table->longText('concepto');
            $table->date('fecha')->nullable();
            $table->year('ano')->nullable();
            $table->text('ruta_archivo')->nullable();
            $table->text('nombre_original')->nullable();
            $table->string('archivo_nombre_generado')->nullable();
            $table->string('archivo_tamano')->nullable();
            $table->string('archivo_tipo')->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->text('compania_id')->nullable();
            $table->text('personal_id')->nullable();
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resoluciones');
    }
};
