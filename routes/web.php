<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuarioController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

// Usuarios
Route::resource('usuarios', UsuarioController::class);
