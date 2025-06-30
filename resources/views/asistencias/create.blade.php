@extends('layouts.app')

@section('title', 'Asistencia')
@section('content_header_title', 'Asistencia')
@section('content_header_subtitle', 'Registro')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title mb-0">Registro de Asistencia</h3>
            </div>
            <div class="card-tools">
                <a href="{{ route('asistencias.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('asistencias.store') }}" method="POST">
                @include('asistencias.partials._form')
            </form>
        </div>
    </div>

@stop
