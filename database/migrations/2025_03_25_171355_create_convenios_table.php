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
        Schema::create('convenios', function (Blueprint $table) {
            $table->id('id_convenio');
            $table->uuid('cod')->unique();
            $table->string('titulo');
            $table->foreignId('institucion_id')->nullable()->constrained('instituciones', 'id_institucion');
            $table->foreignId('estado_id')->nullable()->constrained('convenio_estados', 'idconvenio_estado');
            $table->date('fecha_suscrito');
            $table->date('fecha_fin');
            $table->integer('presidente_id');
            $table->integer('secretario_id')->nullable();
            $table->integer('otros_id')->nullable();
            $table->integer('anho_suscrito');
            $table->integer('anho_fin');
            $table->boolean('vigente')->default(true);
            $table->string('archivo')->comment('ruta del archivo')->default(true);
            $table->string('archivo_nombre')->default(true);
            $table->string('archivo_tamano')->nullable();
            $table->string('archivo_tipo')->nullable();
            $table->foreignId('creador_id')->nullable()->constrained('users', 'id');
            $table->foreignId('updater_id')->nullable()->constrained('users', 'id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convenios');
    }
};
