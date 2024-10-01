<?php

use App\Http\Controllers\ResolutionController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/descargar-resolucion/{resolution}', [ResolutionController::class, 'download'])->name('descargar.resolucion');
