<?php

namespace App\Models\vistas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResolucionView extends Model
{
    use HasFactory;

    protected $table = 'vista_resoluciones';

    protected $primaryKey = 'id_resolucion';

    public $timestamps = false;

    public function scopeBuscar($query, $value)
    {
        $query->where('n_resolucion', 'like', "%{$value}%")
        ->orWhere('concepto', 'like', "%{$value}%")
        ->orWhere('ano', 'like', "%{$value}%")
        ->orWhere('fuente_origen', 'like', "%{$value}%")
        ->orWhere('tipo_documento', 'like', "%{$value}%");
    }
}
