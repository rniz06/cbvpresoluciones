<?php

namespace App\Models\vistas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResolucionPersonalView extends Model
{
    use HasFactory;

    protected $table = 'vt_resoluciones_personales';

    protected $primaryKey = 'id_resolucion';

    public $timestamps = false;
}
