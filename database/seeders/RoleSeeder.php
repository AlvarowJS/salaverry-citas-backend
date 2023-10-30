<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Admin', 'description' => 'Administrador total'],
            ['name' => 'User', 'description' => 'Secretario o usuario normal'],
            // Agrega más roles si es necesario
        ];

        // Insertar los roles en la tabla 'roles'
        DB::table('roles')->insert($roles);
    }
}
