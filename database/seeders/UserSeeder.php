<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'username' => 'Ximena Arraya',
                'email' => 'admin@admin.com',
                'password' => Hash::make('Passw0rd'),
                'role' => 'admin',
            ],
//            [
//                'username' => 'Profesor 1',
//                'email' => 'profesor1@gmail.com',
//                'password' => Hash::make('Passw0rd'),
//                'role' => 'profesor',
//            ],
//            [
//                'username' => 'Alumno 1',
//                'email' => 'alumno1@gmail.com',
//                'password' => Hash::make('Passw0rd'),
//                'role' => 'alumno'
//            ],
//            [
//                'username' => 'Gestor',
//                'email' => 'gestor@gmail.com',
//                'password' => Hash::make('Passw0rd'),
//                'role' => 'gestor'
//            ]
        ];

        DB::table('users')->insert($users);


    }
}
