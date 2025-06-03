@extends('layouts.app')

@section('title', 'Cursos')
@section('content_header_title', 'Cursos')
@section('content_header_subtitle', 'Registro')

@section('content_body')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Registro de Cursos</h3>
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
            <form action="{{ route('cursos.store') }}" method="POST">
                @include('cursos.partials._form')
            </form>
        </div>
    </div>

@stop