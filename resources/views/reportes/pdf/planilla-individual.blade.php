<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos Individuales y Control de Asistencia</title>
    <link rel="stylesheet" href="{{ public_path('assets/css/planillas.css') }}"> </head>
<body>

<div class="page-container">
    <div class="header-section">
        <h1>Cursos individuales</h1>
        <div class="header-details">
            <p>Profesor/a: <span></span></p>
            <p>Curso EU: <span></span></p>
            <p>Nivel: <span></span></p>
            <p>Año: <span></span></p>
            <p>Inicio: <span></span></p>
            <p>Libro: <span></span></p>
        </div>
    </div>

    <div class="table-section course-table">
        <table>
            <thead>
            <tr>
                <th class="small-col"></th>
                <th>Fecha</th>
                <th>Lección/Tema</th>
                <th>Horas</th>
                <th>Firma</th>
                <th>Nº de Alum</th>
                <th>Observaciones</th>
            </tr>
            </thead>
            <tbody>
            @for ($i = 1; $i <= 20; $i++)
                <tr>
                    <td class="small-col">{{ $i }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endfor
            </tbody>
        </table>
    </div>

    <div class="table-section attendance-table">
        <h2>Control de asistencia curso individual o +</h2>
        <table>
            <thead>
            <tr>
                <th class="small-col"></th>
                <th>Nombre y Apellido</th>
                <th>Teléfono</th>
                @for ($i = 1; $i <= 20; $i++)
                    <th class="day-col">{{ $i }}</th>
                @endfor
            </tr>
            </thead>
            <tbody>
            @for ($i = 1; $i <= 10; $i++)
                <tr>
                    <td class="small-col">{{ $i }}</td>
                    <td></td>
                    <td></td>
                    @for ($j = 1; $j <= 20; $j++)
                        <td class="day-col"></td>
                    @endfor
                </tr>
            @endfor
            </tbody>
        </table>
    </div>
    <div class="table-section grade-table">
        <h2>Notas</h2>
        <table>
            <thead>
            <tr>
                <th class="small-col"></th>
                <th>Nombre y Apellido</th>
                @for ($i = 1; $i <= 8; $i++)
                    <th class="grade-col">{{ $i }}</th>
                @endfor
                <th class="grade-col">FINAL</th>
            </tr>
            </thead>
            <tbody>
            @for ($i = 1; $i <= 5; $i++)
                <tr>
                    <td class="small-col">{{ $i }}</td>
                    <td></td>
                    @for ($j = 1; $j <= 8; $j++)
                        <td class="grade-col"></td>
                    @endfor
                    <td></td>
                </tr>
            @endfor
            </tbody>
        </table>
        <div class="observations">
            <p>Observaciones:</p>
            <div class="observation-line"></div>
            <div class="observation-line"></div>
        </div>
    </div>
</div>

</body>
</html>
