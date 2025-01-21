<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Resolucion\Archivo;
use App\Observers\ResolucionObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

#[ObservedBy([ResolucionObserver::class])]
class Resolucion extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = "resoluciones";

    protected $fillable = [
        'n_resolucion',
        'nro_acta',
        'concepto',
        'fecha',
        'ano',
        'usuario_id',
        'ruta_archivo',
        'nombre_original',
        'archivo_nombre_generado',
        'archivo_tamano',
        'archivo_tipo',
        'compania_id',
        'personal_id',
        'fuente_origen_id',
        'tipo_documento_id',
    ];

    /**
     * Relacion uno a muchos con la tabla "users" a travez del campo "usuario_id"
     * Una resolucion debe ser agregado por un usuario
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Relacion uno a muchos con la tabla "fuete_origen" a travez del campo "fuente_origen_id"
    public function fuenteOrigen()
    {
        return $this->belongsTo(FuenteOrigen::class, 'fuente_origen_id');
    }

    // Relacion uno a muchos con la tabla "tipo_documentos" a travez del campo "tipo_documento_id"
    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id');
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
            'personal_id' => 'array',
            'compania_id' => 'array',
        ];
    }

    public function getPersonalNamesAttribute()
    {
        $ids = $this->personal_id;
        // Asegúrate de que $ids sea una cadena y luego convierte a array
        $idsArray = is_array($ids) ? $ids : explode(',', $ids);
        // Escapa los IDs para evitar inyecciones SQL
        $idsArray = array_map('intval', $idsArray);

        $results = Personal::whereIn('idpersonal', $idsArray)
            ->orderBy('nombrecompleto')
            ->pluck('nombrecompleto')
            ->toArray();

        // Unir los nombres en una sola cadena
        return implode(', ', $results);
    }

    public function getPersonalView()
    {
        $ids = $this->personal_id;
        // Asegúrate de que $ids sea una cadena y luego convierte a array
        $idsArray = is_array($ids) ? $ids : explode(',', $ids);
        // Escapa los IDs para evitar inyecciones SQL
        $idsArray = array_map('intval', $idsArray);

        $results = Personal::whereIn('idpersonal', $idsArray)
            ->orderBy('nombrecompleto')
            ->select(DB::raw("CONCAT(nombrecompleto, ' - ', codigo, ' - ', categoria) as info"))
            ->pluck('info')
            ->toArray();

        return $results;
    }

    public function getCompaniasNamesAttribute()
    {
        $ids = $this->compania_id;

        // Asegúrate de que $ids sea una cadena y luego convierte a array
        $idsArray = is_array($ids) ? $ids : explode(',', $ids);

        // Escapa los IDs para evitar inyecciones SQL
        $idsArray = array_map('intval', $idsArray);

        $results = Compania::whereIn('idcompanias', $idsArray)
            ->orderBy('compania')
            ->selectRaw("compania")
            ->get()
            ->pluck('compania')
            ->toArray();

        return $results;
    }

    public function scopeBuscar($query, $value)
    {
        $query->where('n_resolucion', 'like', "%{$value}%")
        ->orWhere('concepto', 'like', "%{$value}%");
    }
}
