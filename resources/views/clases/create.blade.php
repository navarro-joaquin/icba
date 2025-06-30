@extends('layouts.app')

@section('title', 'Clases')
@section('content_header_title', 'Clases')
@section('content_header_subtitle', 'Registro')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title mb-0">Registro de Clases</h3>
            </div>
            <div class="card-tools">
                <a href="{{ route('clases.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('clases.store') }}" method="POST">
                @include('clases.partials._form')
            </form>
        </div>
    </div>

@stop
