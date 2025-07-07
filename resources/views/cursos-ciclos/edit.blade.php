@extends('layouts.app')

@section('title', 'Cursos y Ciclos')
@section('content_header_title', 'Cursos y Ciclos')
@section('content_header_subtitle', 'Editar')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title">Editar Curso y Ciclo: {{ $curso_ciclo->nombre }}</h3>
            </div>
            <div class="card-tools">
                <a href="{{ route('alumnos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('cursos-ciclos.update', $curso_ciclo->id) }}" method="POST">
                @include('cursos-ciclos.partials._form', ['curso_ciclo' => $curso_ciclo])
            </form>
        </div>
    </div>

@stop
