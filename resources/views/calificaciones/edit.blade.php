@extends('layouts.app')

@section('title', 'Calificaciones')
@section('content_header_title', 'Calificaciones')
@section('content_header_subtitle', 'Editar')

@section('content_body')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Editar Calificación: {{ $calificacion->tipo }}</h3>
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
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('calificaciones.update', $calificacion->id) }}" method="POST">
                @include('calificaciones.partials._form', ['calificacion' => $calificacion])
            </form>
        </div>
    </div>

@stop
