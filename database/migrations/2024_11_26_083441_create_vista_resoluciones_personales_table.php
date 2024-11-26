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
        DB::statement("DROP VIEW IF EXISTS vt_resoluciones_personales");
        DB::statement("
            CREATE VIEW `vt_resoluciones_personales` AS
    
            SELECT 
                `resoluciones`.`id` AS `id_resolucion`,
                `resoluciones`.`n_resolucion` AS `n_resolucion`,
                `resoluciones`.`concepto` AS `concepto`,
                `resoluciones`.`fecha` AS `fecha`,
                `resoluciones`.`ano` AS `ano`,
                `tipo_documentos`.`tipo` AS `tipo_documento`,
                `fuente_origen`.`origen` AS `fuente_origen`,
                `vt_personales`.`idpersonal` AS `id_personal`,
                `vt_personales`.`nombrecompleto` AS `nombre_completo`,
                `vt_personales`.`codigo` AS `codigo`,
                `vt_personales`.`documento` AS `documento`,
                `vt_personales`.`fecha_juramento` AS `fecha_juramento`,
                `vt_personales`.`categoria` AS `categoria`,
                `vt_personales`.`estado` AS `estado`,
                `vt_personales`.`sexo` AS `sexo`,
                `vt_personales`.`pais` AS `pais`,
                `vt_personales`.`compania` AS `compania`,
                `resoluciones`.`usuario_id` AS `usuario_id`,
                `tipo_documentos`.`id` AS `tipo_documento_id`,
                `fuente_origen`.`id` AS `fuente_origen_id`
            FROM
                (((((`resoluciones`
                LEFT JOIN `tipo_documentos` ON (`resoluciones`.`tipo_documento_id` = `tipo_documentos`.`id`))
                LEFT JOIN `fuente_origen` ON (`resoluciones`.`fuente_origen_id` = `fuente_origen`.`id`))
                LEFT JOIN `users` ON (`resoluciones`.`usuario_id` = `users`.`id`))
                LEFT JOIN `resoluciones_personales` ON (`resoluciones`.`id` = `resoluciones_personales`.`resolucion_id`))
                LEFT JOIN `personalcbvp`.`vt_personales` ON (`cbvp_resoluciones_db`.`resoluciones_personales`.`personal_id` = `vt_personales`.`idpersonal`))
                ");

    }

    /**
     * Reverse the migrations.
     */
    // public function down(): void
    // {
    //     Schema::dropIfExists('vista_resoluciones_personales');
    // }
};
