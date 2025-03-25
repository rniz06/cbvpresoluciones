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
        Schema::create('instituciones', function (Blueprint $table) {
            $table->id('id_institucion');
            $table->string('nombre', 100);
            $table->string('domicilio', 100);
            $table->string('correo', 40)->nullable();
            $table->string('telefono', 40)->nullable();
            $table->integer('ciudad_id')->nullable();
            $table->integer('pais_id')->nullable();
            $table->string('representante', 100);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instituciones');
    }
};
