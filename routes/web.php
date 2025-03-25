<?php

use App\Http\Controllers\ConvenioController;
use App\Http\Controllers\ResolutionController;
use App\Livewire\ResolucionDetalle;
use App\Livewire\ResolucionesPublic;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/descargar-resolucion/{resolution}', [ResolutionController::class, 'download'])->name('descargar.resolucion');
Route::get('/', ResolucionesPublic::class);
Route::get('/resolucion/detalle/{resolucion}', ResolucionDetalle::class)->name('resolucion.detalle');

Route::middleware('auth')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Modulo Convenios
    |--------------------------------------------------------------------------
    */
    Route::controller(ConvenioController::class)->group(function () {
        Route::get('/descargar-convenio/{record}', 'download')->name('descargar.convenio');
        // Route::get('convenios', 'index')->name('convenios.index');
        // Route::get('convenios/create', 'create')->name('convenios.create');
        // Route::post('convenios/store', 'store')->name('convenios.store');
        // Route::get('convenios/{convenio}', 'show')->name('convenios.show');
        // Route::get('convenios/{convenio}/edit', 'edit')->name('convenios.edit');
        // Route::put('convenios/{convenio}', 'update')->name('convenios.update');
        // Route::delete('convenios/{convenio}', 'destroy')->name('convenios.destroy');
    });
});
