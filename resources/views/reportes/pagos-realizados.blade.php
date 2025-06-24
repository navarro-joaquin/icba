@extends('layouts.app')

@section('title', 'Pagos Realizados')
@section('content_header_title', 'Reportes')
@section('content_header_subtitle', 'Pagos Realizados')

@section('content_body')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title mb-0">Consulta de Pagos Realizados</h3>
            </div>
        </div>
        <div class="card-body">
            <form id="dateFilterForm">
                <div class="mb-3">
                    <label for="fecha_inicio">Fecha inicial:</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="fecha_fin">Fecha final:</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="forma_pago">Forma de pago:</label>
                    <select name="forma_pago" id="forma_pago" class="form-control">
                        <option value="">-- Todos --</option>
                        <option value="efectivo">Efectivo</option>
                        <option value="transferencia">Transferencia Bancaria</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="card-title mb-0">Listado de Pagos Realizados</h3>
            </div>
        </div>
        <div class="card-body">
            <x-adminlte-datatable id="pagos-table" :heads="$heads" :config="$config"></x-adminlte-datatable>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-danger ml-2" id="generarPdfBtn" disabled>
                <i class="fas fa-file-pdf"></i> Generar PDF
            </button>
        </div>
    </div>

@stop

@push('js')
    <script>
        $(document).ready(function() {
            var table = $('#pagos-table').DataTable(); // Obtener la instancia de la tabla

            // La URL inicial ya está establecida a través de $config en el PHP.
            // Ahora, vamos a definir la función 'data' directamente en las propiedades de AJAX de la tabla.
            // Esto se asegura de que se ejecute en cada solicitud, incluyendo la inicial.
            table.ajax.url('{{ route('reportes.pagos-realizados.data') }}'); // Asegurarse que la URL es un string.

            // Define la función `data` para el AJAX de la tabla.
            // Esta es la forma correcta de inyectar parámetros dinámicos.
            table.settings()[0].ajax.data = function(d) {
                d.fecha_inicio = $('#fecha_inicio').val();
                d.fecha_fin = $('#fecha_fin').val();
                d.forma_pago = $('#forma_pago').val();
            };

            // Para la carga inicial, si tu controlador ya maneja un estado vacío con `whereRaw('1 = 0')`
            // cuando `fecha_inicio` y `fecha_fin` están vacíos, no necesitas una recarga explícita aquí.
            // Si necesitas forzar la aplicación de la función `data` en la primera carga:
            // table.ajax.reload(null, false);


            // Revisa que este ID coincida con el ID de tu formulario HTML
            $('#dateFilterForm').on('submit', function(e) {
                e.preventDefault(); // Detener el envío por defecto del formulario

                // Simplemente recarga la tabla. La función `data` que acabamos de configurar
                // se ejecutará automáticamente para obtener los valores de los inputs.
                table.ajax.reload(null, false); // null para callback, false para no resetear paginación

                // Habilitar el botón de PDF
                $('#generarPdfBtn').prop('disabled', false);
            });

            $('#generarPdfBtn').on('click', function() {
                var fecha_inicio = $('#fecha_inicio').val()
                var fecha_fin = $('#fecha_fin').val()
                var forma_pago = $('#forma_pago').val()

                var PdfUrl = '{{ route('reportes.pagos-realizados.pdf') }}'
                PdfUrl += '?fecha_inicio=' + fecha_inicio
                PdfUrl += '&fecha_fin=' + fecha_fin
                PdfUrl += '&forma_pago=' + forma_pago

                window.open(PdfUrl, '_blank')
            })
        });
    </script>
@endpush
