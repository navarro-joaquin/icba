<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\CicloController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\CursoCicloController;
use App\Http\Controllers\CursoProfesorController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\PagoMatriculaController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\AuditoriaController;

Auth::routes();

Route::middleware('auth')->group(function () {
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

    // Ciclos
    Route::get('ciclos/data', [CicloController::class, 'data'])->name('ciclos.data');
    Route::get('ciclos/{ciclo}/fechas', [CicloController::class, 'fechas'])->name('ciclos.fechas');
    Route::resource('ciclos', CicloController::class)->parameters(['ciclos' => 'ciclo']);

    // Cursos
    Route::get('cursos/data', [CursoController::class, 'data'])->name('cursos.data');
    Route::resource('cursos', CursoController::class);

    // Curso - Ciclo
    Route::get('cursos-ciclos/data', [CursoCicloController::class, 'data'])->name('cursos-ciclos.data');
    Route::resource('cursos-ciclos', CursoCicloController::class)->parameters(['cursos-ciclos' => 'curso-ciclo']);

    // CursoCiclo - Profesor
    Route::get('cursos-profesores/data', [CursoProfesorController::class, 'data'])->name('cursos-profesores.data');
    Route::resource('cursos-profesores', CursoProfesorController::class)->parameters(['cursos-profesores' => 'curso-profesor']);

    // Matriculas
    Route::get('matriculas/data', [MatriculaController::class, 'data'])->name('matriculas.data');
    Route::resource('matriculas', MatriculaController::class);

    // Pagos de Matriculas
    Route::get('pagos-matriculas/data', [PagoMatriculaController::class, 'data'])->name('pagos-matriculas.data');
    Route::resource('pagos-matriculas', PagoMatriculaController::class)->parameters(['pagos-matriculas' => 'pago-matricula']);

    // Inscripciones
    Route::get('inscripciones/data', [InscripcionController::class, 'data'])->name('inscripciones.data');
    Route::resource('inscripciones', InscripcionController::class)->parameters(['inscripciones' => 'inscripcion']);

    // Calificaciones
    Route::get('calificaciones/data', [CalificacionController::class, 'data'])->name('calificaciones.data');
    Route::resource('calificaciones', CalificacionController::class)->parameters(['calificaciones' => 'calificacion']);

    // Pagos
    Route::get('pagos/data', [PagoController::class, 'data'])->name('pagos.data');
    Route::resource('pagos', PagoController::class);

    // Reportes
    Route::get('reportes/pagos-realizados', [ReporteController::class, 'pagosRealizados'])->name('reportes.pagos-realizados');
    Route::get('reportes/pagos-realizados/data', [ReporteController::class, 'pagosRealizadosData'])->name('reportes.pagos-realizados.data');
    Route::get('reportes/pagos-realizados/pdf', [ReporteController::class, 'pagosRealizadosPDF'])->name('reportes.pagos-realizados.pdf');

    Route::get('reportes/alumnos-con-deuda', [ReporteController::class, 'alumnosConDeuda'])->name('reportes.alumnos-con-deuda');
    Route::get('reportes/alumnos-con-deuda/data', [ReporteController::class, 'alumnosConDeudaData'])->name('reportes.alumnos-con-deuda.data');
    Route::get('reportes/alumnos-con-deuda/pdf', [ReporteController::class, 'alumnosConDeudaPDF'])->name('reportes.alumnos-con-deuda.pdf');

    Route::get('reportes/planillas', [ReporteController::class, 'planillas'])->name('reportes.planillas');
    Route::get('reportes/planillas/calificaciones/data', [ReporteController::class, 'planillasCalificacionesData'])->name('reportes.planillas.calificaciones.data');
    Route::get('reportes/planillas/regular/pdf', [ReporteController::class, 'planillaRegularPDF'])->name('reportes.planillas.regular.pdf');
    Route::get('reportes/planillas/individual/pdf', [ReporteController::class, 'planillaIndividualPDF'])->name('reportes.planillas.individual.pdf');

    // Auditoria
    Route::get('auditoria', [AuditoriaController::class, 'index'])->name('auditoria');
});
