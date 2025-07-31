<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos con Deuda</title>
    <link rel="stylesheet" href="{{ public_path('assets/css/styles.css') }}">
</head>
<body>
<div class="container">
    <header class="report-header">
        <h1>Alumnos con Deuda</h1>
        <div class="header-info">
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
            <td></td>
            <th>Alumno</th>
            <th>Concepto</th>
            <th>Tipo</th>
            <th>Monto Adeudado</th>
            <th>Descripción</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($resultados as $resultado)
                <tr>
                    <td>{{ $resultado['fila_id'] }}</td>
                    <td>{{ $resultado['alumno_nombre'] }}</td>
                    <td>{{ $resultado['concepto'] }}</td>
                    <td>{{ $resultado['tipo'] }}</td>
                    <td class="monto">{{ $resultado['deuda'] }} Bs.</td>
                    <td>{{ $resultado['descripcion'] }}</td>
                </tr>
            @endforeach
        <tr>
            <td colspan="4"><strong>Total Bs.:</strong></td>
            <td class="monto" colspan="2">{{ number_format($totalDeuda, 2) }}</td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
