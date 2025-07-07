@extends('layouts.app')

@section('title', 'Matriculas')
@section('content_header_title', 'Matriculas')
@section('content_header_subtitle', 'Registrar')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title">Registrar Matricula</h3>
            </div>
            <div class="card-tools">
                <a href="{{ route('matriculas.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('matriculas.store') }}" method="POST">
                @include('matriculas.partials._form')
            </form>
        </div>
    </div>

@stop
