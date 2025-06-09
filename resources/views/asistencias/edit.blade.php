@extends('layouts.app')

@section('title', 'Asistencias')
@section('content_header_title', 'Asistencias')
@section('content_header_subtitle', 'Editar')

@section('content_body')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Editar Asistencia: {{ $asistencia->id }}</h3>
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
            <form action="{{ route('asistencias.update', $asistencia->id) }}" method="POST">
                @include('asistencias.partials._form', ['asistencia' => $asistencia])
            </form>
        </div>
    </div>

@stop
