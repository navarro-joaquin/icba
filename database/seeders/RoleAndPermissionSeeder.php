<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar la caché de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear roles y asignar permisos
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleGestor1 = Role::create(['name' => 'gestor1']);
        $roleGestor2 = Role::create(['name' => 'gestor2']);
        $roleAlumno = Role::create(['name' => 'alumno']);
        $roleProfesor = Role::create(['name' => 'profesor']);

        $roleAdmin->givePermissionTo(Permission::all());
        $roleGestor1->givePermissionTo(
            [
                'ver operaciones',
                'ver usuarios',
                'crear usuarios',
                'ver alumnos',
                'crear alumnos',
                'editar alumnos',
                'ver profesores',
                'crear profesores',
                'editar profesores',
                'ver ciclos',
                'crear ciclos',
                'editar ciclos',
                'ver cursos',
                'crear cursos',
                'editar cursos',
                'ver asignaciones',
                'ver cursos-ciclos',
                'crear cursos-ciclos',
                'editar cursos-ciclos',
                'ver cursos-profesores',
                'crear cursos-profesores',
                'editar cursos-profesores',
                'ver gestion-academica',
                'ver matriculas',
                'crear matriculas',
                'ver pagos-matriculas',
                'crear pagos-matriculas',
                'ver inscripciones',
                'crear inscripciones',
                'ver pagos',
                'crear pagos',
                'ver calificaciones',
                'crear calificaciones',
                'ver reportes',

            ]
        );
        $roleGestor2->givePermissionTo([
            'ver operaciones',
            'ver usuarios',
            'crear usuarios',
            'ver alumnos',
            'crear alumnos',
            'editar alumnos',
            'ver profesores',
            'crear profesores',
            'editar profesores',
            'ver ciclos',
            'crear ciclos',
            'editar ciclos',
            'ver cursos',
            'crear cursos',
            'editar cursos',
            'ver asignaciones',
            'ver cursos-ciclos',
            'crear cursos-ciclos',
            'editar cursos-ciclos',
            'ver cursos-profesores',
            'crear cursos-profesores',
            'editar cursos-profesores',
            'ver gestion-academica',
            'ver matriculas',
            'crear matriculas',
            'ver pagos-matriculas',
            'crear pagos-matriculas',
            'ver inscripciones',
            'crear inscripciones',
            'ver pagos',
            'crear pagos',
            'ver calificaciones',
            'crear calificaciones'
        ]);

        $roleAlumno->givePermissionTo([
            'ver matriculas',
            'ver pagos-matriculas',
            'ver inscripciones',
            'ver pagos',
            'ver calificaciones'
        ]);

        $roleProfesor->givePermissionTo([
            'ver calificaciones',
            'crear calificaciones',
            'editar calificaciones'
        ]);

        // Asignar roles a los usuarios
        $adminUser = User::find(1);
//        $profesorUser = User::find(2);
//        $alumnoUser = User::find(3);
//        $gestorUser = User::find(4);

        $adminUser->assignRole($roleAdmin);
//        $profesorUser->assignRole($roleProfesor);
//        $alumnoUser->assignRole($roleAlumno);
//        $gestorUser->assignRole($roleGestor);
    }
}
