<?php

namespace Database\Seeders;

use App\Models\Multiuso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MultiusoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Multiuso::create([
            'nombre_multiuso' => 'Multiusos',
            'estado' => true,
        ]);
    }
}
