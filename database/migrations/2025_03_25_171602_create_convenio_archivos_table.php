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
        Schema::create('convenio_archivos', function (Blueprint $table) {
            $table->id('idconvenio_archivo');
            $table->foreignId('convenio_id')->nullable()->constrained('convenios', 'id_convenio');
            $table->string('archivo_nombre');
            $table->string('archivo_nombre_generado')->nullable();
            $table->string('archivo_tamano')->nullable();
            $table->string('archivo_tipo')->nullable();
            $table->text('archivo_ruta');
            $table->boolean('principal')->nullable();
            $table->foreignId('creador_id')->nullable()->constrained('users', 'id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convenio_archivos');
    }
};
