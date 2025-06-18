<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\GestionController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\CursoGestionController;
use App\Http\Controllers\CursoProfesorController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ClaseController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\ReporteController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

// Usuarios
Route::get('usuarios/data', [UsuarioController::class, 'data'])->name('usuarios.data');
Route::resource('usuarios', UsuarioController::class);

// Alumnos
Route::get('alumnos/data', [AlumnoController::class, 'data'])->name('alumnos.data');
Route::resource('alumnos', AlumnoController::class);

// Profesores
Route::get('profesores/data', [ProfesorController::class, 'data'])->name('profesores.data');
Route::resource('profesores', ProfesorController::class)->parameters(['profesores' => 'profesor']);

// Gestiones
Route::get('gestiones/data', [GestionController::class, 'data'])->name('gestiones.data');
Route::resource('gestiones', GestionController::class)->parameters(['gestiones' => 'gestion']);

// Cursos
Route::get('cursos/data', [CursoController::class, 'data'])->name('cursos.data');
Route::resource('cursos', CursoController::class);

// Curso - Gestion
Route::get('cursos-gestiones/data', [CursoGestionController::class, 'data'])->name('cursos-gestiones.data');
Route::resource('cursos-gestiones', CursoGestionController::class)->parameters(['cursos-gestiones' => 'curso-gestion']);

// CursoGestion - Profesor
Route::get('cursos-profesores/data', [CursoProfesorController::class, 'data'])->name('cursos-profesores.data');
Route::resource('cursos-profesores', CursoProfesorController::class)->parameters(['cursos-profesores' => 'curso-profesor']);

// Inscripciones
Route::get('inscripciones/data', [InscripcionController::class, 'data'])->name('inscripciones.data');
Route::resource('inscripciones', InscripcionController::class)->parameters(['inscripciones' => 'inscripcion']);

// Calificaciones
Route::get('calificaciones/data', [CalificacionController::class, 'data'])->name('calificaciones.data');
Route::resource('calificaciones', CalificacionController::class)->parameters(['calificaciones' => 'calificacion']);

// Pagos
Route::get('pagos/data', [PagoController::class, 'data'])->name('pagos.data');
Route::resource('pagos', PagoController::class);

// Clases
Route::get('clases/data', [ClaseController::class, 'data'])->name('clases.data');
Route::resource('clases', ClaseController::class);

// Asistencias
Route::get('asistencias/data', [AsistenciaController::class, 'data'])->name('asistencias.data');
Route::resource('asistencias', AsistenciaController::class);

// Reportes
Route::get('reportes/pagos-realizados', [ReporteController::class, 'pagosRealizados'])->name('reportes.pagos-realizados');
Route::get('reportes/pagos-realizados/data', [ReporteController::class, 'pagosRealizadosData'])->name('reportes.pagos-realizados.data');

Route::get('reportes/alumnos-con-deuda', [ReporteController::class, 'alumnosConDeuda'])->name('reportes.alumnos-con-deuda');
Route::get('reportes/alumnos-con-deuda/data', [ReporteController::class, 'alumnosConDeudaData'])->name('reportes.alumnos-con-deuda.data');

Route::get('reportes/planillas', [ReporteController::class, 'planillas'])->name('reportes.planillas');
