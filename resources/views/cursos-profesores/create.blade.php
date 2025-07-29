@extends('layouts.app')

@section('title', 'Cursos y Profesores')
@section('content_header_title', 'Cursos y Profesores')
@section('content_header_subtitle', 'Registro')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title mb-0">Registro de Cursos y Profesores</h3>
            </div>
            <div class="card-tools">
                <a href="{{ route('cursos-profesores.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('cursos-profesores.store') }}" method="POST">
                @include('cursos-profesores.partials._form')
            </form>
        </div>
    </div>

@stop
