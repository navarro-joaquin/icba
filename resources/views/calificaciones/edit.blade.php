@extends('layouts.app')

@section('title', 'Calificaciones')
@section('content_header_title', 'Calificaciones')
@section('content_header_subtitle', 'Editar')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title">Editar Calificación: {{ $calificacion->tipo }}</h3>
            </div>
            <div class="card-tools">
                <a href="{{ route('calificaciones.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('calificaciones.update', $calificacion->id) }}" method="POST">
                @include('calificaciones.partials._form', ['calificacion' => $calificacion])
            </form>
        </div>
    </div>

@stop
