<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlumnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alumnos = [
            [
                'nombre' => 'Pedro Lopez',
                'fecha_nacimiento' => '2000-01-01',
                'user_id' => 3,
                'estado' => 'activo'
            ]
        ];

        DB::table('alumnos')->insert($alumnos);
    }
}
