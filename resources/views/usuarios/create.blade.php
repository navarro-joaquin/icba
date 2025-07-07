@extends('layouts.app')

@section('title', 'Usuarios')
@section('content_header_title', 'Usuarios')
@section('content_header_subtitle', 'Registro')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title">Registro de Usuarios</h3>
            </div>
            <div class="card-tools">
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('usuarios.store') }}" method="POST">
                @include('usuarios.partials._form')
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

        $(document).on('change', '#role', function (e) {
            let role = e.target.value
            if (role === 'alumno') {
                $('#alumno').show()
                $('#profesor').hide()
            } else if (role === 'profesor') {
                $('#alumno').hide()
                $('#profesor').show()
            } else {
                $('#alumno').hide()
                $('#profesor').hide()
            }
        })
    </script>
@endpush
