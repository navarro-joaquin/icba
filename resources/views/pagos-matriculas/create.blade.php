@extends('layouts.app')

@section('title', 'Pagos de Matriculas')
@section('content_header_title', 'Pagos de Matriculas')
@section('content_header_subtitle', 'Registro')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title">Registro de Pagos de Matriculas</h3>
            </div>
            <div class="card-tools">
                <a href="{{ route('pagos-matriculas.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('pagos-matriculas.store') }}" method="POST">
                @include('pagos-matriculas.partials._form')
            </form>
        </div>
    </div>

@stop

@push('js')
    <script>
        $(document).on('change', '#alumno_id', function (e) {
            const alumno_id = e.target.value
            const matriculaSelect = $('#matricula_id')

            if (alumno_id) {
                matriculaSelect.empty()
                matriculaSelect.append('<option value="">-- Seleccione una Matricula --</option>')
                $.get('/matriculas/obtener/' + alumno_id, function (data) {
                    $.each(data, function (index, matriculas) {
                        if (matriculas.length === 0) {
                            matriculaSelect.empty()
                            matriculaSelect.append('<option value="">-- El alumno no tiene matriculas activas o pendientes --</option>')
                        } else {
                            matriculas.map((matricula) => {
                                matriculaSelect.append('<option value="' + matricula.id + '">' + matricula.anio + '</option>')
                            })
                        }
                    })
                })
            } else {
                matriculaSelect.empty()
                matriculaSelect.append('<option value="">-- Seleccione una opción --</option>')
            }
        })
    </script>
@endpush
