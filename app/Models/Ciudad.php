<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    protected $connection = "db_companias";

    protected $table = "ciudades";

    protected $primaryKey = 'idciudades';

    // Relacion Inversa
    public function instituciones()
    {
        return $this->hasMany(Institucion::class);
    }
}
