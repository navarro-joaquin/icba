@extends('layouts.app')

@section('title', 'Cursos y Gestiones')
@section('content_header_title', 'Cursos y Gestiones')
@section('content_header_subtitle', 'Listado')

@section('content_body')

<div class="card">
    <div class="card-header d-flex align-items-center">
        <div class="flex-grow-1">
            <h3 class="card-title mb-0"></h3>
        </div>
        <a href="{{ route('cursos-gestiones.create') }}" class="btn btn-success">
            <i class="fas fa-user-plus"></i> Nuevo Curso y Gestión
        </a>
    </div>
    <div class="card-body">
        <x-adminlte-datatable id="curso-gestion-table" :heads="$heads" :config="$config"></x-adminlte-datatable>
    </div>
</div>

@stop

@push('js')
<script>

</script>
@endpush