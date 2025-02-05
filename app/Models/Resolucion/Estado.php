<?php

namespace App\Models\Resolucion;

use App\Models\Resolucion;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = "resoluciones_estados";

    protected $primaryKey = "id_resolucion_estado";

    protected $fillable = [
        'estado',
    ];

    // Relacion uno a muchos inversa con la tabla de barrios
    public function resoluciones()
    {
        return $this->hasMany(Resolucion::class);
    }
}
