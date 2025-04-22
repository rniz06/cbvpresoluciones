<?php

namespace App\Models;

use App\Models\Convenio\Estado;
use App\Models\Vistas\VtPersonal;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Convenio extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "convenios";

    protected $primaryKey = 'id_convenio';

    protected $fillable = [
        'cod',
        'titulo',
        'institucion_id',
        'estado_id',
        'fecha_suscrito',
        'fecha_fin',
        'anho_suscrito',
        'anho_fin',
        'presidente_id',
        'secretario_id',
        'otros_id',
        'archivo',
        'archivo_nombre',
        'archivo_tipo',
        'archivo_tamano',
        'creador_id',
        'updater_id'
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'institucion_id');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function presidente()
    {
        return $this->belongsTo(Personal::class, 'presidente_id');
    }

    public function secretario()
    {
        return $this->belongsTo(Personal::class, 'secretario_id');
    }

    public function otros()
    {
        return $this->belongsTo(Personal::class, 'otros_id');
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'creador_id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updater_id');
    }
}
