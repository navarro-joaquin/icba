@extends('layouts.app')

@section('title', 'Pagos')
@section('content_header_title', 'Pagos')
@section('content_header_subtitle', 'Editar')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title">Editar Pago del Curso: {{ $pago->inscripcion->cursoGestion->nombre }} del Alumno: {{ $pago->alumno->nombre }}</h3>
            </div>
            <div class="card-tools">
                <a href="{{ route('pagos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('pagos.update', $pago->id) }}" method="POST">
                @include('pagos.partials._form', ['pago' => $pago])
            </form>
        </div>
    </div>

@stop
