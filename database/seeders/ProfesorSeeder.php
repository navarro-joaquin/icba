<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfesorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profesores = [
            [
                'nombre' => 'Esteban Fernandez',
                'especialidad' => 'Ingles',
                'user_id' => 2,
                'estado' => 'activo'
            ]
        ];

        DB::table('profesores')->insert($profesores);
    }
}
