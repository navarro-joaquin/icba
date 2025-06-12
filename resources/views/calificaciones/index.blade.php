@extends('layouts.app')

@section('title', 'Calificaciones')
@section('content_header_title', 'Calificaciones')
@section('content_header_subtitle', 'Listado')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title mb-0">Listado de Calificaciones</h3>
            </div>
            @can('crear calificaciones')
                <a href="{{ route('calificaciones.create') }}" class="btn btn-success">
                    <i class="fas fa-user-plus"></i> Nueva Calificación
                </a>
            @endcan
        </div>
        <div class="card-body">
            <x-adminlte-datatable id="calificaciones-table" :heads="$heads" :config="$config"></x-adminlte-datatable>
        </div>
    </div>

@stop

@push('js')
    <script>
        $(document).on('click', '.btn-delete', function() {
            const id = $(this).data('id')
            let title = '¿Desea eliminar la Calificación?'
            let confirmText = 'Si, eliminar'
            Swal.fire({
                title: title,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: confirmText,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('calificaciones.destroy', ':id') }}'.replace(':id', id),
                        method: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}',
                        },
                        success: (response) => {
                            Swal.fire(response.title, response.message, 'success')
                            $('#calificaciones-table').DataTable().ajax.reload()
                        },
                        error: () => {
                            Swal.fire('Error', 'Ha ocurrido un error al eliminar la calificación', 'error')
                        }
                    })
                }
            })
        })
    </script>
@endpush
