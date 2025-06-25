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
            <th>Alumno</th>
            <th>Curso</th>
            <th>Deuda</th>
            <th>Descripción</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($resultados as $resultado)
                <tr>
                    <td>{{ $resultado['alumno_nombre'] }}</td>
                    <td>{{ $resultado['inscripcion'] }}</td>
                    <td class="monto">{{ $resultado['monto'] }}</td>
                    <td>{{ $resultado['descripcion'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
