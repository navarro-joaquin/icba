@extends('layouts.app')

@section('title', 'Inscripciones')
@section('content_header_title', 'Inscripciones')
@section('content_header_subtitle', 'Editar')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title">Editar Inscripción: {{ $inscripcion->cursoCiclo->nombre }} del Alumno: {{ $inscripcion->alumno->nombre }}</h3>
            </div>
            <div class="card-tools">
                <a href="{{ route('inscripciones.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('inscripciones.update', $inscripcion->id) }}" method="POST">
                @include('inscripciones.partials._form', ['inscripcion' => $inscripcion])
            </form>
        </div>
    </div>

@stop
