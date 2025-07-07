@extends('layouts.app')

@section('title', 'Planillas')
@section('content_header_title', 'Reportes')
@section('content_header_subtitle', 'Planillas')

@section('content_body')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title mb-0">Consulta de Planillas</h3>
            </div>
        </div>
        <div class="card-body">
            <form id="planillaForm">
                <div class="mb-3">
                    <label for="curso_ciclo">Curso:</label>
                    <select name="curso_ciclo" id="curso_ciclo" class="form-control">
                            <option value="">-- Seleccione una opción --</option>
                        @forelse ($cursosCiclos as $cursoCiclo)
                            <option value="{{ $cursoCiclo->id }}">{{ $cursoCiclo->nombre }}</option>
                        @empty
                            <option value="">No hay cursos disponibles</option>
                        @endforelse
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Buscar
                </button>
                <a href="{{ route('reportes.planillas.regular.pdf') }}" class="btn btn-success ml-2" target="_blank">
                    <i class="fas fa-file-pdf"></i> Planilla Curso Regular
                </a>
                <a href="{{ route('reportes.planillas.individual.pdf') }}" class="btn btn-secondary ml-2" target="_blank">
                    <i class="fas fa-file-pdf"></i> Planilla Curso Individual
                </a>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title mb-0">Listado de Calificaciones</h3>
            </div>
        </div>
        <div class="card-body">
            <x-adminlte-datatable id="calificaciones-table" :heads="$calificacionesHeads" :config="$calificacionesConfig"></x-adminlte-datatable>
        </div>
    </div>
@stop

@push('js')

    <script>
        $(document).ready(function () {
            let calificacionesTable = $('#calificaciones-table').DataTable()

            calificacionesTable.ajax.url('{{ route('reportes.planillas.calificaciones.data') }}')

            calificacionesTable.settings()[0].ajax.data = function (d) {
                d.curso_ciclo = $('#curso_ciclo').val()
            }

            $('#planillaForm').on('submit', function (e) {
                e.preventDefault()

                calificacionesTable.ajax.reload(null, false)
            })
        })
    </script>

@endpush
