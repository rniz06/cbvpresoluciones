<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'CBVP Administrador',
            'email' => 'ti@cbvp.org.py',
            'password' => Hash::make('Paraguay2024'),
        ]);

        $this->call([
            FuenteOrigenSeeder::class,
            TipoDocumentoSeeder::class,
        ]);
    }
}
