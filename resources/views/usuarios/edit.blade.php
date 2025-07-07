@extends('layouts.app')

@section('title', 'Usuarios')
@section('content_header_title', 'Usuarios')
@section('content_header_subtitle', 'Editar')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title">Editar Usuario: {{ $usuario->username }}</h3>
            </div>
            <div class="card-tools">
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
                @include('usuarios.partials._form', ['user' => $usuario])
            </form>
        </div>
    </div>

@stop

@push('js')
    <script>
        function togglePassword() {
            let x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
@endpush
