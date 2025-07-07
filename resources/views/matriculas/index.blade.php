@extends('layouts.app')

@section('title', 'Matriculas')
@section('content_header_title', 'Matriculas')
@section('content_header_subtitle', 'Listado')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title mb-0">Listado de Matriculas</h3>
            </div>
            @can('crear matriculas')
                <a href="{{ route('matriculas.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Nueva Matricula
                </a>
            @endcan
        </div>
        <div class="card-body">
            <x-adminlte-datatable id="matriculas-table" :heads="$heads" :config="$config"></x-adminlte-datatable>
        </div>
    </div>

@stop
