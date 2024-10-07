<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Resolucion\Archivo;
use App\Observers\ResolucionObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

// #[ObservedBy([ResolucionObserver::class])]
class Resolucion extends Model
{
    use HasFactory;

    protected $table = "resoluciones";

    protected $fillable = [
        'n_resolucion',
        'concepto',
        'fecha',
        'ano',
        'usuario_id',
        'ruta_archivo',
        'nombre_original',
        'compania_id',
        'personal_id',
    ];

    /**
     * Relacion uno a muchos con la tabla "users" a travez del campo "usuario_id"
     * Una resolucion debe ser agregado por un usuario
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function personales(): BelongsToMany
    {
        return $this->belongsToMany(Personal::class);
    }

    public function companias(): BelongsToMany
    {
        return $this->belongsToMany(Compania::class);
    }

    protected function casts(): array
    {
        return [
            'compania_id' => 'array',
            'personal_id' => 'array',
        ];
    }

    public function getPersonalNamesAttribute()
    {
        $ids = $this->personal_id;

        // Asegúrate de que $ids sea una cadena y luego convierte a array
        $idsArray = is_array($ids) ? $ids : explode(',', $ids);

        // Escapa los IDs para evitar inyecciones SQL
        $idsArray = array_map('intval', $idsArray);

        // Crea una cadena con los IDs para la consulta
        $idsString = implode(',', $idsArray);

        $results = DB::select("
            SELECT
	            idpersonal, nombrecompleto
            FROM
	            personalcbvp.personal
            WHERE 
	            idpersonal IN (1,2,3,4)
            ORDER BY 
	            nombrecompleto;
        ");

        // Extraer solo los nombres de las compañías
        return array_column($results, 'personal');
    }

    public function getCompaniasNamesAttribute()
    {
        $ids = $this->compania_id;

        // Asegúrate de que $ids sea una cadena y luego convierte a array
        $idsArray = is_array($ids) ? $ids : explode(',', $ids);

        // Escapa los IDs para evitar inyecciones SQL
        $idsArray = array_map('intval', $idsArray);

        // Crea una cadena con los IDs para la consulta
        $idsString = implode(',', $idsArray);

        $results = DB::select("
            SELECT 
                idcompanias AS id,
                compania            
            FROM 
                emepy_bd.companias
            WHERE 
                idcompanias IN ($idsString)
            ORDER BY 
                compania;
        ");

        // Extraer solo los nombres de las compañías
        return array_column($results, 'compania');
    }

    
}
