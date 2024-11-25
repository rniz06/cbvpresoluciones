<?php

namespace App\Http\Controllers;

use App\Models\Resolucion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResolutionController extends Controller
{
    public function download($record)
    {
        $data = Resolucion::select('id', 'ruta_archivo', 'nombre_original')->where('id', $record)->first();

        $content = Storage::disk('public')->path($data->ruta_archivo);

        return response()->download($content, $data->nombre_original);

        // $filePath = storage_path('app/public/' . $record->file_path);

        // if (file_exists($filePath)) {
        //     return response()->download($filePath);
        // }

        // return back()->with('error', 'Archivo no encontrado');
    }
}
