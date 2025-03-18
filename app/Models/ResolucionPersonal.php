<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ResolucionPersonal extends Pivot
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "resoluciones_personales";

    protected $primaryKey = 'id_resolucion_personal';

    protected $fillable = [
        'resolucion_id',
        'personal_id',
    ];
}
