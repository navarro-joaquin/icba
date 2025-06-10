@extends('layouts.app')

@section('title', 'Profesores')
@section('content_header_title', 'Profesores')
@section('content_header_subtitle', 'Registro')

@section('content_body')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Registro de Profesores</h3>
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
            <form action="{{ route('profesores.store') }}" method="POST">
                @include('profesores.partials._form')
            </form>
        </div>
    </div>

@stop