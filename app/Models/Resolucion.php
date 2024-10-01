<?php

namespace App\Models;

use App\Models\Resolucion\Archivo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    // protected $casts = [
    //     'ruta_archivo',
    //     'nombre_original',
    // ];

    /**
     * Relacion uno a muchos con la tabla "users" a travez del campo "usuario_id"
     * Una resolucion debe ser agregado por un usuario
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
 
    /**
     * Relacion uno a muchos inversa con la tabla de expediente_archivos
     * Una resolucion puede tener varios archivos
     */
    public function archivos()
    {
        return $this->hasMany(Archivo::class);
    }
}
