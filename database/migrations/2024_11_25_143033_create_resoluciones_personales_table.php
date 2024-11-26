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
        Schema::create('resoluciones_personales', function (Blueprint $table) {
            $table->id('id_resolucion_personal');
            $table->unsignedBigInteger('resolucion_id')->nullable();
            $table->unsignedBigInteger('personal_id')->nullable();
            $table->timestamps();

            $table->foreign('resolucion_id')->references('id')->on('resoluciones')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resoluciones_personales');
    }
};
