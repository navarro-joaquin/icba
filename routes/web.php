<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\ProfesorController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

// Usuarios
Route::get('usuarios/data', [UsuarioController::class, 'data'])->name('usuarios.data');
Route::resource('usuarios', UsuarioController::class);

// Alumnos
Route::get('alumnos/data', [AlumnoController::class, 'data'])->name('alumnos.data');
Route::resource('alumnos', AlumnoController::class);

Route::get('profesores/data', [ProfesorController::class, 'data'])->name('profesores.data');
Route::resource('profesores', ProfesorController::class)->parameters(['profesores' => 'profesor']);

