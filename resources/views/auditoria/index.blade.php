@extends('layouts.app')

@section('title', 'Auditoria')
@section('content_header_title', 'Auditoria')
@section('content_header_subtitle', 'Listado')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title mb-0">Registros de Auditoría</h3>
            </div>
        </div>
        <div class="card-body">
            <x-adminlte-datatable id="auditTable" :heads="$heads" :config="$config">
                @foreach($tableData as $row)
                    <tr>
                        <td>{{ $row['user'] }}</td>
                        <td>{{ $row['operation'] }}</td>
                        <td>{{ $row['model_type'] }}</td>
                        <td>{{ $row['record_id'] }}</td>
                        <td>{{ $row['date_time'] }}</td>
                        <td><pre style="white-space: pre-wrap;">{{ $row['old_values'] }}</pre></td>
                        <td><pre style="white-space: pre-wrap;">{{ $row['new_values'] }}</pre></td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>

@stop
