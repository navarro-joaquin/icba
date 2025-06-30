@extends('layouts.app')

@section('title', 'Cursos y Gestiones')
@section('content_header_title', 'Cursos y Gestiones')
@section('content_header_subtitle', 'Editar')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title">Editar Curso y Gestion: {{ $curso_gestion->nombre }}</h3>
            </div>
            <div class="card-tools">
                <a href="{{ route('alumnos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('cursos-gestiones.update', $curso_gestion->id) }}" method="POST">
                @include('cursos-gestiones.partials._form', ['curso_gestion' => $curso_gestion])
            </form>
        </div>
    </div>

@stop
