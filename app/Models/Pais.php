<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $connection = "db_personal";

    protected $table = "paises";

    protected $primaryKey = 'idpaises';

    // Relacion Inversa
    public function instituciones()
    {
        return $this->hasMany(Institucion::class);
    }
}
