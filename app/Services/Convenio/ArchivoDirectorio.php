<?php

namespace App\Services\Convenio;

class ArchivoDirectorio
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function archivodirectorio()
    {
        $anho = date('Y');
        return 'convenios/' . $anho;
    }
}
