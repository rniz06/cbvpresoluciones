<?php

namespace App\Observers;

use App\Models\Resolucion;
use Illuminate\Support\Facades\DB;

class ResolucionObserver
{
    /**
     * Handle the Resolucion "created" event.
     */
    public function created(Resolucion $resolucion): void
    {
        // Obtenemos el id de la resolucion creada
        $resolucion_id = $resolucion->id;

        // Obtenemos el array con los ids de las companias afectadas
        $companias = $resolucion->compania_id;

        // Obtenemos el array con los ids de los personales afectados
        $personales = $resolucion->personal_id;

        // verificamos la existencia de datos en la variable companias
        if ($companias) {
            // Luego, insertamos en la tabla pivote
            foreach ($companias as $compania_id) {
                DB::table('resoluciones_companias')->insert([
                    'resolucion_id' => $resolucion_id,  // ID de la resolución guardada
                    'compania_id'   => $compania_id,      // ID de la compañía
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            }
        }

        // verificamos la existencia de datos en la variable personales
        // if ($personales) {
        //     // Luego, insertamos en la tabla pivote
        //     foreach ($personales as $personal_id) {
        //         DB::table('resoluciones_personales')->insert([
        //             'resolucion_id' => $resolucion_id,  // ID de la resolución guardada
        //             'personal_id'   => $personal_id,      // ID de la compañía
        //             'created_at'    => now(),
        //             'updated_at'    => now(),
        //         ]);
        //     }
        // }
    }

    /**
     * Handle the Resolucion "updated" event.
     */
    public function updated(Resolucion $resolucion): void
    {
        // Primero, elimina los registros existentes para esta resolución
        DB::table('resoluciones_companias')
            ->where('resolucion_id', $resolucion->id)
            ->delete();

        // DB::table('resoluciones_personales')
        //     ->where('resolucion_id', $resolucion->id)
        //     ->delete();

        // Luego, inserta los nuevos registros (igual que en el método created)
        $companias = $resolucion->compania_id;
        if ($companias) {
            foreach ($companias as $compania_id) {
                DB::table('resoluciones_companias')->insert([
                    'resolucion_id' => $resolucion->id,
                    'compania_id'   => $compania_id,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            }
        }

        // $personales = $resolucion->personal_id;
        // if ($personales) {
        //     foreach ($personales as $personal_id) {
        //         DB::table('resoluciones_personales')->insert([
        //             'resolucion_id' => $resolucion->id,
        //             'personal_id'   => $personal_id,
        //             'created_at'    => now(),
        //             'updated_at'    => now(),
        //         ]);
        //     }
        // }
    }

    /**
     * Handle the Resolucion "deleted" event.
     */
    public function deleted(Resolucion $resolucion): void
    {
        //
    }

    /**
     * Handle the Resolucion "restored" event.
     */
    public function restored(Resolucion $resolucion): void
    {
        //
    }

    /**
     * Handle the Resolucion "force deleted" event.
     */
    public function forceDeleted(Resolucion $resolucion): void
    {
        //
    }
}
