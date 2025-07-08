@extends('layouts.app')

@section('title', 'Pagos de Matriculas')
@section('content_header_title', 'Pagos de Matriculas')
@section('content_header_subtitle', 'Editar')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title">Editar Pago de la Matricula: {{ $pago_matricula->matricula->anio }} del Alumno: {{ $pago_matricula->alumno->nombre }}</h3>
            </div>
            <div class="card-tools">
                <a href="{{ route('pagos-matriculas.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('pagos-matriculas.update', $pago_matricula->id) }}" method="POST">
                @include('pagos-matriculas.partials._form', ['pago_matricula' => $pago_matricula])
            </form>
        </div>
    </div>

@stop
