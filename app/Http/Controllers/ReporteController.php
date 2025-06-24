<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscripcion;
use App\Models\Clase;
use App\Models\Pago;
use App\Models\Calificacion;
use App\Models\CursoGestion;
use App\Models\Asistencia;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    public function pagosRealizados()
    {
        $heads = [
            'Fecha',
            'Alumno',
            'Monto',
            'Forma de pago',
            'Descripcion'
        ];

        $config = [
            'processing' => true,
            'serverSide' => true,
            'ajax' => [
                'url' => route('reportes.pagos-realizados.data'),
                'type' => 'GET',
                'dataSrc' => 'data'
            ],
            'columns' => [
                ['data' => 'fecha_pago', 'name' => 'fecha_pago'],
                ['data' => 'alumno_nombre', 'name' => 'alumno_nombre'],
                ['data' => 'monto', 'name' => 'monto'],
                ['data' => 'forma_pago', 'name' => 'forma_pago'],
                ['data' => 'descripcion', 'name' => 'descripcion']
            ],
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            ]
        ];
        return view('reportes.pagos-realizados', compact('heads', 'config'));
    }

    public function pagosRealizadosData(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $formaPago = $request->input('forma_pago');

        $query = Pago::query();

        if (!empty($fechaInicio) && !empty($fechaFin)) {
            // Ajustado para incluir todo el día de fin
            $query->whereBetween('fecha_pago', [$fechaInicio, $fechaFin . ' 23:59:59']);
            if (!empty($formaPago)) {
                $query->where('forma_pago', $formaPago);
            }
        } else {
            // Esto asegura que la tabla esté vacía inicialmente si no hay fechas
            $query->whereRaw('1 = 0');
        }

        return DataTables::of($query)
            ->addColumn('alumno_nombre', fn ($pago) => $pago->alumno->nombre ?? '')
            ->addIndexColumn()
            ->make(true);
    }

    public function pagosrealizadosPDF(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $formaPago = $request->input('forma_pago');

        $query = Pago::query();

        if (!empty($fechaInicio) && !empty($fechaFin)) {
            $query->whereBetween('fecha_pago', [$fechaInicio, $fechaFin . ' 23:59:59']);
            if (!empty($formaPago)) {
                $query->where('forma_pago', $formaPago);
            } else {
                $formaPago = 'Todos';
            }
        } else {
            $query->whereRaw('1 = 0');
        }

        $pagos = $query->with('alumno')->get();

        //return view('reportes.pdf.pagos-realizados', compact('pagos', 'fechaInicio', 'fechaFin', 'formaPago'));

        $pdf = Pdf::loadView('reportes.pdf.pagos-realizados', compact('pagos', 'fechaInicio', 'fechaFin', 'formaPago'));
        return $pdf->stream('pagos-realizados.pdf');
    }

    public function alumnosConDeuda()
    {
        $heads = [
            'Alumno',
            'Inscripción',
            'Monto',
            'Descripción'
        ];

        $config = [
            'processing' => true,
            'serverSide' => true,
            'ajax' => [
                'url' => route('reportes.alumnos-con-deuda.data'),
                'type' => 'GET',
                'dataSrc' => 'data'
            ],
            'columns' => [
                ['data' => 'alumno_nombre', 'name' => 'alumno_nombre'],
                ['data' => 'inscripcion', 'name' => 'inscripcion'],
                ['data' => 'monto', 'name' => 'monto'],
                ['data' => 'descripcion', 'name' => 'descripcion']
            ],
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            ]
        ];

        return view('reportes.alumnos-con-deuda', compact('heads', 'config'));
    }

    public function alumnosConDeudaData()
    {
        // Obtener todas las inscripciones con sus relaciones
        $inscripciones = Inscripcion::with(['alumno', 'pagos' => function($query) {
            $query->orderBy('fecha_pago', 'desc');
        }, 'cursoGestion.curso'])->get();

        $resultados = $inscripciones->map(function($inscripcion) {
            $tienePagos = $inscripcion->pagos->isNotEmpty();
            $totalPagado = $inscripcion->pagos->sum('monto');
            $deuda = $inscripcion->monto_total - $totalPagado;

            // Incluir si no tiene pagos o si tiene deuda
            if (!$tienePagos || $deuda > 0) {
                $ultimoPago = $inscripcion->pagos->first();

                return [
                    'alumno_nombre' => $inscripcion->alumno->nombre ?? 'Sin nombre',
                    'inscripcion' => 'Inscripción al Curso: ' . ($inscripcion->cursoGestion->nombre ?? 'Curso no encontrado'),
                    'monto' => number_format($deuda, 2) . ' Bs.',
                    'descripcion' => $tienePagos
                        ? 'Último pago: ' . ($ultimoPago->descripcion ?? '') . ($ultimoPago ? ' (' . $ultimoPago->fecha_pago . ')' : '')
                        : 'Sin pagos registrados',
                    'deuda' => $deuda // Para ordenamiento
                ];
            }
            return null;
        })
        ->filter()
        ->sortByDesc('deuda')
        ->values();

        return DataTables::of($resultados)
            ->addIndexColumn()
            ->make(true);
    }

    public function alumnosConDeudaPDF()
    {
        $inscripciones = Inscripcion::with(['alumno', 'pagos' => function($query) {
            $query->orderBy('fecha_pago', 'desc');
        }, 'cursoGestion.curso'])->get();

        $resultados = $inscripciones->map(function($inscripcion) {
            $tienePagos = $inscripcion->pagos->isNotEmpty();
            $totalPagado = $inscripcion->pagos->sum('monto');
            $deuda = $inscripcion->monto_total - $totalPagado;

            // Incluir si no tiene pagos o si tiene deuda
            if (!$tienePagos || $deuda > 0) {
                $ultimoPago = $inscripcion->pagos->first();

                return [
                    'alumno_nombre' => $inscripcion->alumno->nombre ?? 'Sin nombre',
                    'inscripcion' => 'Inscripción al Curso: ' . ($inscripcion->cursoGestion->nombre ?? 'Curso no encontrado'),
                    'monto' => number_format($deuda, 2) . ' Bs.',
                    'descripcion' => $tienePagos
                        ? 'Último pago: ' . ($ultimoPago->descripcion ?? '') . ($ultimoPago ? ' (' . $ultimoPago->fecha_pago . ')' : '')
                        : 'Sin pagos registrados',
                    'deuda' => $deuda // Para ordenamiento
                ];
            }
            return null;
        })
        ->filter()
        ->sortByDesc('deuda')
        ->values();

        //return view('reportes.pdf.alumnos-con-deuda', compact('resultados'));

        $pdf = Pdf::loadView('reportes.pdf.alumnos-con-deuda', ['resultados' => $resultados]);
        return $pdf->stream();
    }

    public function planillas()
    {
        $cursosGestiones = CursoGestion::where('estado', 'activo')->get();

        $clasesHeads = [
            'Número de Clase',
            'Fecha de Clase',
            'Tema'
        ];

        $clasesConfig = [
            'processing' => true,
            'serverSide' => true,
            'ajax' => [
                'url' => route('reportes.planillas.clases.data'),
                'type' => 'GET',
                'dataSrc' => 'data'
            ],
            'columns' => [
                ['data' => 'numero_clase', 'name' => 'numero_clase'],
                ['data' => 'fecha_clase', 'name' => 'fecha_clase'],
                ['data' => 'tema', 'name' => 'tema']
            ],
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            ]
        ];

        $asistenciasHeads = [
            'Inscripción',
            'Clase',
            'Presente'
        ];

        $asistenciasConfig = [
            'processing' => true,
            'serverSide' => true,
            'ajax' => [
                'url' => route('reportes.planillas.asistencias.data'),
                'type' => 'GET',
                'dataSrc' => 'data'
            ],
            'columns' => [
                ['data' => 'inscripcion_nombre', 'name' => 'inscripcion_nombre'],
                ['data' => 'clase_nombre', 'name' => 'clase_nombre'],
                ['data' => 'presente', 'name' => 'presente']
            ],
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            ]
        ];

        $calificacionesHeads = [
            'Inscripción',
            'Tipo',
            'Nota'
        ];

        $calificacionesConfig = [
            'processing' => true,
            'serverSide' => true,
            'ajax' => [
                'url' => route('reportes.planillas.calificaciones.data'),
                'type' => 'GET',
                'dataSrc' => 'data'
            ],
            'columns' => [
                ['data' => 'inscripcion_nombre', 'name' => 'inscripcion_nombre'],
                ['data' => 'tipo', 'name' => 'tipo'],
                ['data' => 'nota', 'name' => 'nota']
            ],
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            ]
        ];

        return view('reportes.planillas', compact('cursosGestiones', 'clasesHeads', 'clasesConfig', 'asistenciasHeads', 'asistenciasConfig', 'calificacionesHeads', 'calificacionesConfig'));
    }

    public function planillasClasesData(Request $request)
    {
        $cursoGestionId = $request->curso_gestion;

        if (!empty($cursoGestionId)) {
            $clases = Clase::with(['cursoGestion.curso'])
                ->where('curso_gestion_id', $cursoGestionId)
                ->orderBy('fecha_clase', 'asc')
                ->get();
        } else {
            $clases = collect();
        }

        return DataTables::of($clases)
            ->addColumn('numero_clase', function($clase) {
                return $clase->numero_clase;
            })
            ->addColumn('fecha_clase', function($clase) {
                return $clase->fecha_clase;
            })
            ->addColumn('tema', function($clase) {
                return $clase->tema ?: 'Sin tema especificado';
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function planillasAsistenciasData(Request $request)
    {
        $cursoGestionId = $request->curso_gestion;

        if (!empty($cursoGestionId)) {
            $asistencias = Asistencia::with([
                    'inscripcion.alumno',
                    'inscripcion.cursoGestion',
                    'clase' => function($query) {
                        $query->orderBy('fecha_clase', 'asc');
                    }
                ])
                ->whereHas('inscripcion', function($query) use ($cursoGestionId) {
                    $query->where('curso_gestion_id', $cursoGestionId);
                })
                ->get()
                ->sortBy(function($asistencia) {
                    return $asistencia->clase->fecha_clase ?? '';
                });
        } else {
            $asistencias = collect();
        }

        return DataTables::of($asistencias)
            ->addColumn('inscripcion_nombre', function ($asistencia) {
                return $asistencia->inscripcion->alumno->nombre . ' - (' . $asistencia->inscripcion->cursoGestion->nombre . ')' ?? '';
            })
            ->addColumn('clase_nombre', function ($asistencia) {
                return 'N° ' . $asistencia->clase->numero_clase . ' - (' . $asistencia->clase->fecha_clase . ')' ?? '';
            })
            ->addColumn('presente', function($asistencia) {
                if ($asistencia->presente) {
                    return '<input type="checkbox" checked disabled />';
                } else {
                    return '<input type="checkbox" disabled />';
                }
            })
            ->rawColumns(['presente'])
            ->addIndexColumn()
            ->make(true);
    }

    public function planillasCalificacionesData(Request $request)
    {
        $cursoGestion = $request->curso_gestion;

        if (!empty($cursoGestion)) {
            $calificaciones = Calificacion::whereHas('inscripcion', function ($query) use ($cursoGestion) {
                $query->whereHas('cursoGestion', function ($query) use ($cursoGestion) {
                    $query->where('id', $cursoGestion);
                });
            })
                ->with(['inscripcion.alumno', 'inscripcion.cursoGestion.clases' => function ($query) use ($request) {
                    $query->where('clases.id', $request->clase);
                }])
                ->get();
        } else {
            $calificaciones = Calificacion::whereRaw('1 = 0');
        }

        return DataTables::of($calificaciones)
            ->addColumn('inscripcion_nombre', function ($calificacion) {
                return $calificacion->inscripcion->alumno->nombre . ' - (' . $calificacion->inscripcion->cursoGestion->nombre . ')' ?? '';
            })
            ->addColumn('tipo', function ($calificacion) {
                switch ($calificacion->tipo) {
                    case 'examen_1':
                        return 'Examen 1';
                    case 'examen_2':
                        return 'Examen 2';
                    case 'nota_final':
                        return 'Nota Final';
                    default:
                        return '';
                }
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function planillaRegularPDF()
    {
        $pdf = Pdf::loadView('reportes.pdf.planilla-regular');
        return $pdf->stream('curso-regular.pdf');
    }

    public function planillaIndividualPDF()
    {
        $pdf = Pdf::loadView('reportes.pdf.planilla-individual');
        return $pdf->stream('curso-individual.pdf');
    }
}
