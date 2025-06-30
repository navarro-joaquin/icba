@extends('layouts.app')

@section('title', 'Cursos y Profesores')
@section('content_header_title', 'Cursos y Profesores')
@section('content_header_subtitle', 'Editar')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title">Editar Curso y Profesor: {{ $curso_profesor->nombre }}</h3>
            </div>
            <div class="card-tools">
                <a href="{{ route('alumnos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('cursos-profesores.update', $curso_profesor->id) }}" method="POST">
                @include('cursos-profesores.partials._form', ['curso_profesor' => $curso_profesor])
            </form>
        </div>
    </div>

@stop
