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
        DB::statement("
                    CREATE
                    VIEW `cbvpresoluciones`.`vista_resoluciones` AS
                        SELECT
                            `cbvpresoluciones`.`resoluciones`.`id` AS `id_resolucion`,
                            `cbvpresoluciones`.`resoluciones`.`n_resolucion` AS `n_resolucion`,
                            `cbvpresoluciones`.`resoluciones`.`concepto` AS `concepto`,
                            `cbvpresoluciones`.`resoluciones`.`fecha` AS `fecha`,
                            `cbvpresoluciones`.`resoluciones`.`ano` AS `ano`,
                            `cbvpresoluciones`.`users`.`name` AS `usuario_nombre`,
                            `cbvpresoluciones`.`tipo_documentos`.`tipo` AS `tipo_documento`,
                            `cbvpresoluciones`.`fuente_origen`.`origen` AS `fuente_origen`,
                            `cbvpresoluciones`.`resoluciones`.`usuario_id` AS `usuario_id`,
                            `cbvpresoluciones`.`tipo_documentos`.`id` AS `tipo_documento_id`,
                            `cbvpresoluciones`.`fuente_origen`.`id` AS `fuente_origen_id`
                        FROM
                            (((`cbvpresoluciones`.`resoluciones`
                            LEFT JOIN `cbvpresoluciones`.`tipo_documentos` ON (`cbvpresoluciones`.`resoluciones`.`tipo_documento_id` = `cbvpresoluciones`.`tipo_documentos`.`id`))
                            LEFT JOIN `cbvpresoluciones`.`fuente_origen` ON (`cbvpresoluciones`.`resoluciones`.`fuente_origen_id` = `cbvpresoluciones`.`fuente_origen`.`id`))
                            LEFT JOIN `cbvpresoluciones`.`users` ON (`cbvpresoluciones`.`resoluciones`.`usuario_id` = `cbvpresoluciones`.`users`.`id`))

        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vista_resoluciones");
    }
};
