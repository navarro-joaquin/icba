@extends('layouts.app')

@section('title', 'Cursos')
@section('content_header_title', 'Cursos')
@section('content_header_subtitle', 'Editar')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title">Editar Curso: {{ $curso->nombre }}</h3>
            </div>
            <div class="card-tools">
                <a href="{{ route('cursos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('cursos.update', $curso->id) }}" method="POST">
                @include('cursos.partials._form', ['curso' => $curso])
            </form>
        </div>
    </div>

@stop
