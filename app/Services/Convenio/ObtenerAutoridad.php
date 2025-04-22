<?php

namespace App\Services\Convenio;

use App\Models\Personal;

class ObtenerAutoridad
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function presidente()
    {
        $presidente = Personal::select('idpersonal', 'nombrecompleto', 'codigo', 'categoria')->where('codigo', 507)->first();
        return $presidente ? "{$presidente->nombrecompleto} - {$presidente->codigo} - {$presidente->categoria}" : null;
    }

    public static function secretario()
    {
        $secretario = Personal::select('idpersonal', 'nombrecompleto', 'codigo', 'categoria')->where('codigo', 497)->first();
        return $secretario ? "{$secretario->nombrecompleto} - {$secretario->codigo} - {$secretario->categoria}" : null;
    }
}
