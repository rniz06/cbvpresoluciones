<?php

namespace App\Models\Convenio;

use App\Models\Convenio;
use App\Models\User;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Archivo extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "convenio_archivos";

    protected $primaryKey = 'idconvenio_archivo';

    protected $fillable = [
        'convenio_id',
        'archivo_nombre',
        'archivo_nombre_generado',
        'archivo_tamano',
        'archivo_tipo',
        'archivo_ruta',
        'principal',
        'creador_id'
    ];

    // Relacion Inversa
    public function convenios()
    {
        return $this->hasMany(Convenio::class);
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creador_id');
    }
}
