<?php

namespace App\Models\Convenio;

use App\Models\Convenio;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "convenio_estados";

    protected $primaryKey = 'idconvenio_estado';

    protected $fillable = [
        'estado',
    ];

    // Relacion Inversa
    public function convenios()
    {
        return $this->hasMany(Convenio::class);
    }
}
