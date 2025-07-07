@extends('layouts.app')

@section('title', 'Cursos y Ciclos')
@section('content_header_title', 'Cursos y Ciclos')
@section('content_header_subtitle', 'Registro')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title">Registro de Cursos y Ciclos</h3>
            </div>
            <div class="card-tools">
                <a href="{{ route('alumnos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('cursos-ciclos.store') }}" method="POST">
                @include('cursos-ciclos.partials._form')
            </form>
        </div>
    </div>

@stop

@push('js')
    <script>
        $(document).on('change', '#ciclo_id', function (e) {
            let fecha_inicio = document.getElementById('fecha_inicio')
            let fecha_fin = document.getElementById('fecha_fin')
            let ciclo_id = e.target.value
            if (ciclo_id) {
                $.get('/ciclos/' + ciclo_id + '/fechas', function (data) {
                    fecha_inicio.value = data.fecha_inicio
                    fecha_fin.value = data.fecha_fin
                })
            } else {
                fecha_inicio.value = ''
                fecha_fin.value = ''
            }
        });
    </script>

@endpush
