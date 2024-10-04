<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Compania extends Model
{
    use HasFactory;

    protected $connection = "db_companias";

    protected $table = "companias";

    public static function getSelectOptions()
    {
        $results = DB::select("
            SELECT 
                idcompanias AS id,
                CONCAT(compania, ' - ', departamento, ' - ', ciudad) AS label
            FROM 
                emepy_bd.vt_companias
            ORDER BY 
                compania, departamento, ciudad
        ");

        return collect($results)->pluck('label', 'id');
    }
}
