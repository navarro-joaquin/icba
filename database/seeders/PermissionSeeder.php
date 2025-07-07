<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'ver operaciones']);

        // Permisos de usuarios
        Permission::create(['name' => 'ver usuarios']);
        Permission::create(['name' => 'crear usuarios']);
        Permission::create(['name' => 'editar usuarios']);
        Permission::create(['name' => 'eliminar usuarios']);

        // Permisos de alumnos
        Permission::create(['name' => 'ver alumnos']);
        Permission::create(['name' => 'crear alumnos']);
        Permission::create(['name' => 'editar alumnos']);
        Permission::create(['name' => 'eliminar alumnos']);

        // Permisos de profesores
        Permission::create(['name' => 'ver profesores']);
        Permission::create(['name' => 'crear profesores']);
        Permission::create(['name' => 'editar profesores']);
        Permission::create(['name' => 'eliminar profesores']);

        // Permisos de ciclos
        Permission::create(['name' => 'ver ciclos']);
        Permission::create(['name' => 'crear ciclos']);
        Permission::create(['name' => 'editar ciclos']);
        Permission::create(['name' => 'eliminar ciclos']);

        // Permisos de cursos
        Permission::create(['name' => 'ver cursos']);
        Permission::create(['name' => 'crear cursos']);
        Permission::create(['name' => 'editar cursos']);
        Permission::create(['name' => 'eliminar cursos']);

        Permission::create(['name' => 'ver asignaciones']);

        // Permisos de cursos-ciclos
        Permission::create(['name' => 'ver cursos-ciclos']);
        Permission::create(['name' => 'crear cursos-ciclos']);
        Permission::create(['name' => 'editar cursos-ciclos']);
        Permission::create(['name' => 'eliminar cursos-ciclos']);

        // Permisos de cursos-profesores
        Permission::create(['name' => 'ver cursos-profesores']);
        Permission::create(['name' => 'crear cursos-profesores']);
        Permission::create(['name' => 'editar cursos-profesores']);
        Permission::create(['name' => 'eliminar cursos-profesores']);

        Permission::create(['name' => 'ver gestion-academica']);

        // Permisos de matriculas
        Permission::create(['name' => 'ver matriculas']);
        Permission::create(['name' => 'crear matriculas']);
        Permission::create(['name' => 'editar matriculas']);
        Permission::create(['name' => 'eliminar matriculas']);

        // Permisos de pagos de matriculas
        Permission::create(['name' => 'ver pagos-matriculas']);
        Permission::create(['name' => 'crear pagos-matriculas']);
        Permission::create(['name' => 'editar pagos-matriculas']);
        Permission::create(['name' => 'eliminar pagos-matriculas']);

        // Permisos de inscripciones
        Permission::create(['name' => 'ver inscripciones']);
        Permission::create(['name' => 'crear inscripciones']);
        Permission::create(['name' => 'editar inscripciones']);
        Permission::create(['name' => 'eliminar inscripciones']);

        // Permisos de pagos
        Permission::create(['name' => 'ver pagos']);
        Permission::create(['name' => 'crear pagos']);
        Permission::create(['name' => 'editar pagos']);
        Permission::create(['name' => 'eliminar pagos']);

        // Permisos de calificaciones
        Permission::create(['name' => 'ver calificaciones']);
        Permission::create(['name' => 'crear calificaciones']);
        Permission::create(['name' => 'editar calificaciones']);
        Permission::create(['name' => 'eliminar calificaciones']);

        // Permisos del dashboard
        Permission::create(['name' => 'ver reportes']);

        // Auditoria
        Permission::create(['name' => 'ver auditoria']);

    }
}
