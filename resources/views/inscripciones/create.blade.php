@extends('layouts.app')

@section('title', 'Inscripciones')
@section('content_header_title', 'Inscripciones')
@section('content_header_subtitle', 'Registro')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title">Registro de Inscripciones</h3>
            </div>
            <div class="card-tools">
                <a href="{{ route('inscripciones.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('inscripciones.store') }}" method="POST">
                @include('inscripciones.partials._form')
            </form>
        </div>
        <div class="card-footer">
            <span id="estado-matricula">Seleccione un alumno para ver el estado de la matricula</span>
        </div>
    </div>
@stop

@push('js')
    <script>
        $(document).on('change', '#alumno_id', function (e) {
            const alumno_id = e.target.value
            if (alumno_id) {
                $.get('/matriculas/estado/' + alumno_id, function (data) {
                    const span = $('#estado-matricula')
                    const year = new Date().getFullYear()

                    if (data.estado === 'pagada') {
                        span.text('Matricula para el año ' + data.anio + ' pagada.\n' + 'Pagado: Bs. ' + data.pagado + ' de Bs. ' + data.total).removeClass().addClass('text-success')
                    } else if (data.estado === 'pendiente') {
                        span.text('Matricula para el año ' + data.anio + ' pendiente.\n' + 'Pagado: Bs. ' + data.pagado + ' de Bs. ' + data.total).removeClass().addClass('text-danger')
                    } else {
                        span.text('Sin matricula para el año: ' + year + ' registrada').removeClass().addClass('text-warning')
                    }
                })
            } else {
                const span = $('#estado-matricula')
                span.text('Seleccione un alumno para ver el estado de la matricula').removeClass().addClass('text-dark')
            }
        })
    </script>
@endpush
