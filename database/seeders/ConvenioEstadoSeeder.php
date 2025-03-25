<?php

namespace Database\Seeders;

use App\Models\Convenio\Estado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConvenioEstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            'En Ejecución',
            'Culminado',
            'Derogado',
        ];

        foreach ($estados as $permiso) {
            Estado::create(['estado' => $permiso]);
        }
    }
}
