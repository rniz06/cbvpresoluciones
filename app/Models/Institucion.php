<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Institucion extends Model implements Auditable
{
    use SoftDeletes, HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = "instituciones";

    protected $primaryKey = 'id_institucion';

    protected $fillable = [
        'nombre',
        'domicilio',
        'correo',
        'telefono',
        'ciudad_id',
        'pais_id',
        'representante',
    ];
    // Relacion Inversa
    public function convenios()
    {
        return $this->hasMany(Convenio::class);
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'pais_id');
    }
}
