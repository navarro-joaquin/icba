@extends('layouts.app')

@section('title', 'Pagos')
@section('content_header_title', 'Pagos de Inscripciones')
@section('content_header_subtitle', 'Registro')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title">Registro de Pagos de Inscripciones</h3>
            </div>
            <div class="card-tools">
                <a href="{{ route('pagos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('pagos.store') }}" method="POST">
                @include('pagos.partials._form')
            </form>
        </div>
    </div>

@stop

@push('js')
    <script>
        $(document).on('change', '#alumno_id', function (e) {
            const alumno_id = e.target.value
            const inscripcionSelect = $('#inscripcion_id')

            if (alumno_id) {
                inscripcionSelect.empty()
                inscripcionSelect.append('<option value="">-- Seleccione una Inscripción --</option>')
                $.get('/inscripciones/obtener/' + alumno_id, function (data) {
                    $.each(data, function (index, inscripciones) {
                        if (inscripciones.length === 0) {
                            inscripcionSelect.empty()
                            inscripcionSelect.append('<option value="">-- El alumno no tiene inscripciones activas o pendientes --</option>')
                        } else {
                            inscripciones.map((inscripcion) => {
                                inscripcionSelect.append('<option value="' + inscripcion.id + '">' + inscripcion.curso_ciclo.nombre + '</option>')
                            })
                        }
                    })
                })
            } else {
                inscripcionSelect.empty()
                inscripcionSelect.append('<option value="">-- Seleccione una opción --</option>')
            }
        })
    </script>
@endpush
