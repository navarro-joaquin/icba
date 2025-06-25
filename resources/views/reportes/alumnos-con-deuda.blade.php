@extends('layouts.app')

@section('title', 'Alumnos con Deuda')
@section('content_header_title', 'Reportes')
@section('content_header_subtitle', 'Alumnos con Deuda')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title mb-0">Listado de Alumnos con Deuda</h3>
            </div>
        </div>
        <div class="card-body">
            <x-adminlte-datatable id="alumnos-table" :heads="$heads" :config="$config"></x-adminlte-datatable>
        </div>
        <div class="card-footer">
            <a href="{{ route('reportes.alumnos-con-deuda.pdf') }}" class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf"></i> Exportar a PDF
            </a>
        </div>
    </div>


@stop
