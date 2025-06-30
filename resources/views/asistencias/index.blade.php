@extends('layouts.app')

@section('title', 'Asistencias')
@section('content_header_title', 'Asistencias')
@section('content_header_subtitle', 'Listado')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title mb-0">Listado de Asistencias</h3>
            </div>
            @can('crear asistencias')
                <a href="{{ route('asistencias.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Registrar Asistencia
                </a>
            @endcan
        </div>
        <div class="card-body">
            <x-adminlte-datatable id="asistencias-table" :heads="$heads" :config="$config"></x-adminlte-datatable>
        </div>
    </div>


@stop

@push('js')
    <script>
        $(document).on('click', '.btn-delete', function() {
            const id = $(this).data('id')
            let title = 'Eliminar'
            let confirmText = '¿Está seguro que desea eliminar la Asistencia?'
            Swal.fire({
                title: title,
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: confirmText,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('asistencias.destroy', ':id') }}'.replace(':id', id),
                        method: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}',
                        },
                        success: (response) => {
                            Swal.fire(response.title, response.message, 'success')
                            $('#asistencias-table').DataTable().ajax.reload()
                        },
                        error: () => {
                            Swal.fire('Error', 'Ha ocurrido un error al eliminar la asistencia', 'error')
                        }
                    })
                }
            })
        })
    </script>
@endpush
