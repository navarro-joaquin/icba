@extends('layouts.app')

@section('title', 'Pagos de Matriculas')
@section('content_header_title', 'Pagos de Matriculas')
@section('content_header_subtitle', 'Listado')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title mb-0">Listado de Pagos de Matriculas</h3>
            </div>
            @can('crear pagos')
                <a href="{{ route('pagos-matriculas.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Nuevo Pago de Matricula
                </a>
            @endcan
        </div>
        <div class="card-body">
            <x-adminlte-datatable id="pagos-matriculas-table" :heads="$heads" :config="$config"></x-adminlte-datatable>
        </div>
    </div>

@stop

@push('js')
    <script>
        $(document).on('click', '.btn-delete', function() {
            const id = $(this).data('id')
            let title = '¿Desea eliminar el pago de matricula?'
            let confirmText = 'Sí, eliminar'
            Swal.fire({
                title: title,
                icon: 'warning',
                showConfirmButton: true,
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: confirmText
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('pagos-matriculas.destroy', ':id') }}'.replace(':id', id),
                        method: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: (response) => {
                            Swal.fire(response.title, response.message, 'success')
                            $('#pagos-matriculas-table').DataTable().ajax.reload()
                        },
                        error: () => {
                            Swal.fire('Error', 'Ha ocurrido un error al eliminar el pago de matricula', 'error')
                        }
                    })
                }
            })
        })
    </script>
@endpush
