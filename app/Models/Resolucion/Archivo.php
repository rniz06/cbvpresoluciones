<?php

namespace App\Models\Resolucion;

use App\Models\Resolucion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    use HasFactory;

    protected $table = "resolucion_archivos";

    protected $fillable = [
        'nombre_original',
        'nombre_generado',
        'ruta',
        'tamano',
        'tipo',
        'usuario_id',
        'resolucion_id',
    ];
    
    /**
     * Relacion uno a muchos con la tabla "users" a travez del campo "usuario_id"
     * Un archivo debe ser agregado por un usuario
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Relacion uno a muchos con la tabla "expedientes" a travez del campo "expediente_id"
     * Un archivo debe pertenecer a un expediente
     */
    public function resolucion()
    {
        return $this->belongsTo(Resolucion::class, 'resolucion_id');
    }
}
