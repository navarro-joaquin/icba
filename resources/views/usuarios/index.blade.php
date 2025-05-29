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
            <a href="{{ route('usuarios.create') }}" class="btn btn-success">
                <i class="fas fa-user-plus"></i> Nuevo Usuario
            </a>
        </div>
        {{-- <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div> --}}
        <div class="card-body">
            <table class="table table-bordered table-striped" id="usuarios-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@stop

@push('js')
<script>
    // DataTable de Usuarios con Ajax
    $(function () {
        $('#usuarios-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('usuarios.data') }}',
                dataSrc: function (json) {
                    console.log(json)
                    return json.data
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'username', name: 'username' },
                { data: 'email', name: 'email' },
                { data: 'role', name: 'role' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        })
    })

    // SweetAlert2 para eliminar Usuarios
    $(document).on('click', '.btn-delete', function() {
        const id = $(this).data('id')
        Swal.fire({
            title: '¿Desea eliminar el usuario?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
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
                        Swal.fire('Eliminado', response.message, 'success')
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