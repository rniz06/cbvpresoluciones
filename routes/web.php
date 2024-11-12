<?php

use App\Http\Controllers\ResolutionController;
use App\Livewire\ResolucionesPublic;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/descargar-resolucion/{resolution}', [ResolutionController::class, 'download'])->name('descargar.resolucion');
Route::get('/public', ResolucionesPublic::class);
