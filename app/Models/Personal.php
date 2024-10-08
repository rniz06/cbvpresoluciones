<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Personal extends Model
{
    use HasFactory;

    protected $connection = "db_personal";

    protected $table = "personalcbvp.vt_personales";

    protected $primaryKey = 'idpersonal';

    public static function getSelectOptions()
    {
        $results = DB::select("
            SELECT 
                idpersonal AS id,
                CONCAT(nombrecompleto, ' - ', codigo, ' - ', categoria) AS label
            FROM 
                personalcbvp.vt_personales            
            ORDER BY 
                nombrecompleto
        ");

        return collect($results)->pluck('label', 'id');
    }
}
