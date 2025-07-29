@extends('layouts.app')

@section('title', 'Cursos y Ciclos')
@section('content_header_title', 'Cursos y Ciclos')
@section('content_header_subtitle', 'Listado')

@section('content_body')

<div class="card">
    <div class="card-header d-flex align-items-center">
        <div class="flex-grow-1">
            <h3 class="card-title mb-0"></h3>
        </div>
        @can('crear cursos-ciclos')
            <a href="{{ route('cursos-ciclos.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Nuevo Curso y Ciclo
            </a>
        @endcan
    </div>
    <div class="card-body">
        <x-adminlte-datatable id="curso-ciclo-table" :heads="$heads" :config="$config"></x-adminlte-datatable>
    </div>
</div>

@stop

@push('js')
<script>
    // SweetAlert2 para eliminar Curso y Ciclo
    $(document).on('click', '.btn-delete', function() {
        const id = $(this).data('id')
        const estado = $(this).data('estado')
        let title = ''
        let confirmText = ''
        if (estado === 'activo') {
            title = '¿Desea desactivar el registro?'
            confirmText = 'Sí, desactivar'
        } else if (estado === 'inactivo') {
            title = '¿Desea activar el registro?'
            confirmText = 'Sí, activar'
        }
        Swal.fire({
            title: title,
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: confirmText,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('cursos-ciclos.destroy', ':id') }}'.replace(':id', id),
                    method: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}',
                    },
                    success: (response) => {
                        Swal.fire(response.title, response.message, 'success')
                        $('#curso-ciclo-table').DataTable().ajax.reload()
                    },
                    error: () => {
                        Swal.fire('Error', 'Ha ocurrido un error al eliminar el registro', 'error')
                    }
                })
            }
        })
    })
</script>
@endpush
