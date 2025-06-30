@extends('layouts.app')

@section('title', 'Asistencias')
@section('content_header_title', 'Asistencias')
@section('content_header_subtitle', 'Editar')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title">Editar Asistencia: {{ $asistencia->id }}</h3>
            </div>
            <div class="card-tools">
                <a href="{{ route('asistencias.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('asistencias.update', $asistencia->id) }}" method="POST">
                @include('asistencias.partials._form', ['asistencia' => $asistencia])
            </form>
        </div>
    </div>

@stop
