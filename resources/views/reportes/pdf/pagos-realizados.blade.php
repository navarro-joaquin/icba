<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagos realizados</title>
    <link rel="stylesheet" href="{{ public_path('assets/css/styles.css') }}">
</head>
<body>
<div class="container">
    <header class="report-header">
        <h1>Pagos realizados</h1>
        <div class="header-info">
            <p><strong>Desde:</strong> <span id="report-date">{{ $fechaInicio }}</span></p>
            <p><strong>Hasta:</strong> <span id="report-date">{{ $fechaFin }}</span></p>
            <p><strong>Forma de Pago:</strong> <span id="report-date">{{ $formaPago }}</span></p>
            <br>
            <p><strong>Reporte generado el:</strong> <span id="report-date">{{ date('d/m/Y') }}</span></p>
            <p><strong>Por el usuario:</strong> <span id="generated-by">{{ Auth::user()->username }}</span></p>
        </div>
        <div class="logo">
            <img src="{{ public_path('assets/img/icba2.png') }}" alt="ICBA Logo">
        </div>
    </header>

    <table class="tabla">
        <thead>
        <tr>
            <td>ID</td>
            <th>Fecha</th>
            <th>Alumno</th>
            <th>Tipo</th>
            <th>Monto (Bs.)</th>
            <th>Forma de Pago</th>
            <th>Descripción</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($pagos as $pago)
            <tr>
                <td>{{ $pago->id }}</td>
                <td>{{ $pago->fecha_pago }}</td>
                <td>{{ $pago->alumno_nombre }}</td>
                <td>{{ $pago->tipo }}</td>
                <td class="monto">{{ $pago->monto }}</td>
                <td>{{ $pago->forma_pago }}</td>
                <td>{{ $pago->descripcion }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
