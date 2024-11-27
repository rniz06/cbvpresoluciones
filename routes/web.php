<?php

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
