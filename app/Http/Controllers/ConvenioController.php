<?php

namespace App\Http\Controllers;

use App\Models\Convenio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConvenioController extends Controller
{
    public function download($record)
    {
        $data = Convenio::select('id_convenio', 'archivo', 'archivo_nombre')->where('id_convenio', $record)->first();

        $content = Storage::disk('public')->path($data->archivo);

        return response()->download($content, $data->archivo_nombre);

    }
}
