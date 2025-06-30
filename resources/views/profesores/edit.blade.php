@extends('layouts.app')

@section('title', 'Profesores')
@section('content_header_title', 'Profesores')
@section('content_header_subtitle', 'Editar')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title">Editar Profesor: {{ $profesor->nombre }}</h3>
            </div>
            <div class="card-tools">
                <a href="{{ route('profesores.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('profesores.update', $profesor->id) }}" method="POST">
                @include('profesores.partials._form', ['profesor' => $profesor])
            </form>
        </div>
    </div>

@stop
