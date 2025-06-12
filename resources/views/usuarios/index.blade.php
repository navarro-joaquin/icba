@extends('layouts.app')

@section('title', 'Usuarios')
@section('content_header_title', 'Usuarios')
@section('content_header_subtitle', 'Listado')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title mb-0">Listado de Usuarios</h3>
            </div>
            @can('crear usuarios')
                <a href="{{ route('usuarios.create') }}" class="btn btn-success">
                    <i class="fas fa-user-plus"></i> Nuevo Usuario
                </a>
            @endcan
        </div>
        <div class="card-body">
            <x-adminlte-datatable id="usuarios-table" :heads="$heads" :config="$config"></x-adminlte-datatable>
        </div>
    </div>

@stop

@push('js')
<script>
    // SweetAlert2 para eliminar Usuarios
    $(document).on('click', '.btn-delete', function() {
        const id = $(this).data('id')
        const estado = $(this).data('estado')
        let title = ''
        let confirmText = ''

        if (estado == 'active') {
            title = '¿Desea desactivar el usuario?'
            confirmText = 'Sí, desactivar'
        } else {
            title = '¿Desea activar el usuario?'
            confirmText = 'Sí, activar'
        }

        Swal.fire({
            title: title,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: confirmText
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('usuarios.destroy', ':id') }}'.replace(':id', id),
                    method: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}',
                    },
                    success: (response) => {
                        Swal.fire(response.title, response.message, 'success')
                        $('#usuarios-table').DataTable().ajax.reload()
                    },
                    error: () => {
                        Swal.fire('Error', 'Ha ocurrido un error al eliminar el usuario', 'error')
                    }
                })
            }
        })
    })
</script>
@endpush
