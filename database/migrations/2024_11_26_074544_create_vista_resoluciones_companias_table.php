<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("DROP VIEW IF EXISTS vt_resoluciones_companias");
        DB::statement("
    CREATE VIEW `vt_resoluciones_companias` AS
    SELECT 
        `resoluciones`.`id` AS `id_resolucion`,
        `resoluciones`.`n_resolucion` AS `n_resolucion`,
        `resoluciones`.`concepto` AS `concepto`,
        `resoluciones`.`fecha` AS `fecha`,
        `resoluciones`.`ano` AS `ano`,
        `tipo_documentos`.`tipo` AS `tipo_documento`,
        `fuente_origen`.`origen` AS `fuente_origen`,
        `resoluciones`.`usuario_id` AS `usuario_id`,
        `tipo_documentos`.`id` AS `tipo_documento_id`,
        `fuente_origen`.`id` AS `fuente_origen_id`,
        `vt_companias`.`idcompanias` AS `id_compania`,
        `vt_companias`.`compania` AS `compania`,
        `vt_companias`.`departamento` AS `compania_departamento`,
        `vt_companias`.`ciudad` AS `compania_ciudad`,
        `vt_companias`.`region` AS `compania_region`
    FROM
        `resoluciones`
    LEFT JOIN `tipo_documentos` 
        ON `resoluciones`.`tipo_documento_id` = `tipo_documentos`.`id`
    LEFT JOIN `fuente_origen` 
        ON `resoluciones`.`fuente_origen_id` = `fuente_origen`.`id`
    LEFT JOIN `users` 
        ON `resoluciones`.`usuario_id` = `users`.`id`
    LEFT JOIN `resoluciones_companias` 
        ON `resoluciones`.`id` = `resoluciones_companias`.`resolucion_id`
    LEFT JOIN `emepy_bd`.`vt_companias` 
        ON `cbvp_resoluciones_db`.`resoluciones_companias`.`compania_id` = `vt_companias`.`idcompanias`;
");

    }

    /**
     * Reverse the migrations.
     */
    // public function down(): void
    // {
    //     Schema::dropIfExists('vista_resoluciones_companias');
    // }
};
