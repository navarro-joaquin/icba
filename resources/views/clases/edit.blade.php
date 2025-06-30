@extends('layouts.app')

@section('title', 'Clases')
@section('content_header_title', 'Clases')
@section('content_header_subtitle', 'Editar')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title">Editar Clase: {{ $clase->id }}</h3>
            </div>
            <div class="card-tools">
                <a href="{{ route('clases.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('clases.update', $clase->id) }}" method="POST">
                @include('clases.partials._form', ['clase' => $clase])
            </form>
        </div>
    </div>

@stop
