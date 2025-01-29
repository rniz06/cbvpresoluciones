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
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('fuente_origen', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('tipo_documentos', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('resoluciones', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('resoluciones_companias', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('resoluciones_personales', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('fuente_origen', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('tipo_documentos', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('resoluciones', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('resoluciones_companias', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('resoluciones_personales', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
};
