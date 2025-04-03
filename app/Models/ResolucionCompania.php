<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ResolucionCompania extends Pivot
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "resoluciones_companias";

    protected $primaryKey = 'id_resolucion_compania';

    protected $fillable = [
        'resolucion_id',
        'compania_id',
    ];
}
