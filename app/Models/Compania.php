<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Compania extends Model
{
    use HasFactory;

    protected $connection = "db_companias";

    protected $table = "vt_companias";

    protected $primaryKey = 'idcompanias';

    public static function getSelectOptions()
    {
        return Compania::selectRaw('idcompanias AS id, CONCAT(compania, \' - \', departamento, \' - \', ciudad) AS label')
            ->orderBy('compania')
            ->orderBy('departamento')
            ->orderBy('ciudad')
            ->get()
            ->pluck('label', 'id');
    }

    /**
     * The roles that belong to the user.
     */
    public function resoluciones(): BelongsToMany
    {
        return $this->belongsToMany(Resolucion::class, 'compania_resolucion');
    }
}
