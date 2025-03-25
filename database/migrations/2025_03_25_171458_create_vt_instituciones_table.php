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
        DB::statement('
            CREATE VIEW `vt_instituciones` AS
            SELECT
                i.id_institucion,
                i.nombre,
                i.domicilio,
                i.correo,
                i.telefono,
                i.ciudad_id,
                i.pais_id,
                i.representante,
                i.deleted_at,
                c.ciudad,
                p.pais
            FROM instituciones i
            JOIN emepy_bd.ciudades c ON (c.idciudades = i.ciudad_id)
            JOIN personalcbvp.paises p ON (p.idpaises = i.pais_id);
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS vt_instituciones;');
    }
};
