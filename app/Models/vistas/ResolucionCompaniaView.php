<?php

namespace App\Models\vistas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResolucionCompaniaView extends Model
{
    use HasFactory;

    protected $table = 'vt_resoluciones_companias';

    protected $primaryKey = 'id_resolucion';

    public $timestamps = false;
}
