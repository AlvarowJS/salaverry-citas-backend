<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UbicacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ubicacions = [
            ['nombre_ubicacion' => 'Planta base'],
            ['nombre_ubicacion' => 'Primer piso'],
            ['nombre_ubicacion' => 'Segundo Piso'],
            // Agrega más ubicacions si es necesario
        ];

        // Insertar los ubicacions en la tabla 'ubicacions'
        DB::table('ubicacions')->insert($ubicacions);
    }
}
