<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResolucionEstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('resoluciones_estados')->insert([
            'estado' => 'Vigente',
        ]);

        DB::table('resoluciones_estados')->insert([
            'estado' => 'Modificada',
        ]);

        DB::table('resoluciones_estados')->insert([
            'estado' => 'Derogada',
        ]);
    }
}
