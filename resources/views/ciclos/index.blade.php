@extends('layouts.app')

@section('title', 'Ciclos')
@section('content_header_title', 'Ciclos')
@section('content_header_subtitle', 'Listado')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title mb-0">Listado de Ciclos</h3>
            </div>
            @can('crear ciclos')
                <a href="{{ route('ciclos.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Nuevo Ciclo
                </a>
            @endcan
        </div>
        <div class="card-body">
            <x-adminlte-datatable id="ciclos-table" :heads="$heads" :config="$config"></x-adminlte-datatable>
        </div>
    </div>

@stop

@push('js')
<script>
    // SweetAlert2 para eliminar Ciclos
    $(document).on('click', '.btn-delete', function() {
        const id = $(this).data('id')
        const estado = $(this).data('estado')
        let title = ''
        let confirmText = ''
        if (estado === 'activo') {
            title = '¿Desea desactivar el ciclo?'
            confirmText = 'Sí, desactivar'
        } else if (estado === 'inactivo') {
            title = '¿Desea activar el ciclo?'
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
                    url: '{{ route('ciclos.destroy', ':id') }}'.replace(':id', id),
                    method: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}',
                    },
                    success: (response) => {
                        Swal.fire(response.title, response.message, 'success')
                        $('#ciclos-table').DataTable().ajax.reload()
                    },
                    error: () => {
                        Swal.fire('Error', 'Ha ocurrido un error al eliminar el alumno', 'error')
                    }
                })
            }
        })
    })
</script>
@endpush
