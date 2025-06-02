@extends('layouts.app')

@section('title', 'Alumnos')
@section('content_header_title', 'Alumnos')
@section('content_header_subtitle', 'Listado')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title mb-0">Listado de Alumnos</h3>
            </div>
            <a href="{{ route('alumnos.create') }}" class="btn btn-success">
                <i class="fas fa-user-plus"></i> Nuevo Alumno
            </a>
        </div>
        {{-- <div class="card-body">
            <table class="table table-bordered table-striped" id="alumnos-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Usuario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div> --}}
        <div class="card-body">
            <x-adminlte-datatable id="alumnos-table" :heads="$heads" :config="$config"></x-adminlte-datatable>
        </div>
    </div>

@stop

@push('js')
<script>
    // // DataTable de Alumnos con Ajax
    // $(function () {
    //     $('#alumnos-table').DataTable({
    //         processing: true,
    //         serverSide: true,
    //         ajax: {
    //             url: '{{ route('alumnos.data') }}',
    //             dataSrc: function (json) {
    //                 return json.data
    //             }
    //         },
    //         responsive: true,
    //         columns: [
    //             {data: 'id', name: 'id'},
    //             {data: 'nombre', name: 'nombre'},
    //             {data: 'fecha_nacimiento', name: 'fecha_nacimiento'},
    //             {data: 'nombre_usuario', name: 'nombre_usuario'},
    //             {data: 'actions', name: 'actions', orderable: false, searchable: false}
    //         ],
    //         language: {
    //             url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
    //         }
    //     });
    // });

    // SweetAlert2 para eliminar Alumnos
    $(document).on('click', '.btn-delete', function() {
        const id = $(this).data('id')
        Swal.fire({
            title: '¿Desea eliminar el alumno?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('alumnos.destroy', ':id') }}'.replace(':id', id),
                    method: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}',
                    },
                    success: (response) => {
                        Swal.fire('Eliminado', response.message, 'success')
                        $('#alumnos-table').DataTable().ajax.reload()
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