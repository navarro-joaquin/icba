@extends('layouts.app')

@section('title', 'Gestiones')
@section('content_header_title', 'Gestiones')
@section('content_header_subtitle', 'Editar')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title">Editar Gestión: {{ $gestion->nombre }}</h3>
            </div>
            <div class="card-tools">
                <a href="{{ route('gestiones.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('gestiones.update', $gestion->id) }}" method="POST">
                @include('gestiones.partials._form', ['gestion' => $gestion])
            </form>
        </div>
    </div>

@stop
