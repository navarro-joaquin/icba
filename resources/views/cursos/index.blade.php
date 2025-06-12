@extends('layouts.app')

@section('title', 'Cursos')
@section('content_header_title', 'Cursos')
@section('content_header_subtitle', 'Listado')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title mb-0">Listado de Cursos</h3>
            </div>
            @can('crear cursos')
                <a href="{{ route('cursos.create') }}" class="btn btn-success">
                    <i class="fas fa-user-plus"></i> Nuevo Curso
                </a>
            @endcan
        </div>
        <div class="card-body">
            <x-adminlte-datatable id="cursos-table" :heads="$heads" :config="$config"></x-adminlte-datatable>
        </div>
    </div>

@stop

@push('js')
<script>
    // SweetAlert2 para eliminar Profesores
    $(document).on('click', '.btn-delete', function() {
        const id = $(this).data('id')
        const estado = $(this).data('estado')
        let title = ''
        let confirmText = ''
        if (estado === 'activo') {
            title = '¿Desea desactivar al curso?'
            confirmText = 'Sí, desactivar'
        } else if (estado === 'inactivo') {
            title = '¿Desea activar al curso?'
            confirmText = 'Sí, activar'
        }
        Swal.fire({
            title: title,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: confirmText,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('cursos.destroy', ':id') }}'.replace(':id', id),
                    method: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}',
                    },
                    success: (response) => {
                        Swal.fire(response.title, response.message, 'success')
                        $('#cursos-table').DataTable().ajax.reload()
                    },
                    error: () => {
                        Swal.fire('Error', 'Ha ocurrido un error al eliminar el profesor', 'error')
                    }
                })
            }
        })
    })
</script>
@endpush
