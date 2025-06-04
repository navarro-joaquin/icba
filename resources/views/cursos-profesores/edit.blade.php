@extends('layouts.app')

@section('title', 'Cursos y Profesores')
@section('content_header_title', 'Cursos y Profesores')
@section('content_header_subtitle', 'Editar')

@section('content_body')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Editar Curso y Profesor: {{ $curso_profesor->nombre }}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('cursos-profesores.update', $curso_profesor->id) }}" method="POST">
                @include('cursos-profesores.partials._form', ['curso_profesor' => $curso_profesor])
            </form>
        </div>
    </div>

@stop