<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos Regulares y Control de Asistencia</title>
    <link rel="stylesheet" href="{{ public_path('assets/css/planillas.css') }}"> </head>
<body>

<div class="page-container">
    <div class="header-section">
        <h1>Cursos regulares</h1>
        <div class="header-details-table">
            <table>
                <tr>
                    <td><p>Profesor/a:</p></td>
                    <td><p>Módulo:</p></td>
                    <td><p>Nivel:</p></td>
                    <td><p>Año:</p></td>
                </tr>
                <tr>
                    <td><p>Días:</p></td>
                    <td><p>Horario:</p></td>
                    <td><p>Duración:</p></td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="table-section course-table">
        <table>
            <thead>
            <tr>
                <th class="small-col"></th>
                <th>Fecha</th>
                <th>Lección/Tema</th>
                <th>Horas/UE</th>
                <th>Firma</th>
                <th>Nº de Alum</th>
                <th>Observaciones</th>
            </tr>
            </thead>
            <tbody>
            @for ($i = 1; $i <= 11; $i++)
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
        <h2>Control de asistencia A</h2>
        <table>
            <thead>
            <tr>
                <th class="small-col"></th>
                <th>Nombre y Apellido</th>
                <th>Teléfono</th>
                @for ($i = 1; $i <= 11; $i++)
                    <th class="day-col">{{ $i }}</th>
                @endfor
                <th class="small-col">Exa</th>
                <th class="small-col">men</th>
                <th class="small-col">N.F.</th>
            </tr>
            </thead>
            <tbody>
            @for ($i = 1; $i <= 25; $i++)
                <tr>
                    <td class="small-col">{{ $i }}</td>
                    <td></td>
                    <td></td>
                    @for ($j = 1; $j <= 11; $j++)
                        <td class="day-col"></td>
                    @endfor
                    <td class="small-col"></td>
                    <td class="small-col"></td>
                    <td class="small-col"></td>
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
