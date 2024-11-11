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

    protected $table = "vt_personales";

    protected $primaryKey = 'idpersonal';

    public static function getSelectOptions()
    {
        return Personal::selectRaw('idpersonal AS id, CONCAT(nombrecompleto, \' - \', codigo, \' - \', categoria) AS label')
            ->orderBy('nombrecompleto')
            ->get()
            ->pluck('label', 'id');
    }
}
