<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FuenteOrigenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('fuente_origen')->insert([
            'origen' => 'COMANDANCIA',
        ]);

        DB::table('fuente_origen')->insert([
            'origen' => 'DIRECTORIO',
        ]);

        DB::table('fuente_origen')->insert([
            'origen' => 'OTROS',
        ]);
    }
}
