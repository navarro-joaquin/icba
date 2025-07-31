@extends('layouts.app')

@section('title', 'Pagos')
@section('content_header_title', 'Pagos de Inscripciones')
@section('content_header_subtitle', 'Listado')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title mb-0">Listado de Pagos de Inscripciones</h3>
            </div>
            @can('crear pagos')
                <a href="{{ route('pagos.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Nuevo Pago de Inscripción
                </a>
            @endcan
        </div>
        <div class="card-body">
            <x-adminlte-datatable id="pagos-table" :heads="$heads" :config="$config"></x-adminlte-datatable>
        </div>
    </div>

@stop

@push('js')
    <script>
        $(document).on('click', '.btn-delete', function() {
            const id = $(this).data('id')
            let title = '¿Desea eliminar el pago?'
            let confirmText = 'Sí, eliminar'
            Swal.fire({
                title: title,
                icon: 'warning',
                showConfirmButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: confirmText
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('pagos.destroy', ':id') }}'.replace(':id', id),
                        method: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: (response) => {
                            Swal.fire(response.title, response.message, 'success')
                            $('#pagos-table').DataTable().ajax.reload()
                        },
                        error: () => {
                            Swal.fire('Error', 'Ha ocurrido un error al eliminar el pago', 'error')
                        }
                    })
                }
            })
        })
    </script>
@endpush
