<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = "tipo_documentos";

    protected $fillable = [
        'tipo',
    ];

    // Relacion uno a muchos inversa con la tabla de barrios
    public function resoluciones()
    {
        return $this->hasMany(Resolucion::class);
    }
}
