@extends('layouts.app')

@section('title', 'Usuarios')
@section('content_header_title', 'Usuarios')
@section('content_header_subtitle', 'Listado')

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
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
</script>
@endpush