<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscripcion;
use App\Models\Matricula;
use App\Models\Pago;
use App\Models\PagoMatricula;
use App\Models\Calificacion;
use App\Models\CursoCiclo;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function pagosRealizados()
    {
        $heads = [
            'ID',
            'Fecha',
            'Alumno',
            'Tipo',
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
                ['data' => 'fila_id', 'name' => 'fila_id'],
                ['data' => 'fecha_pago', 'name' => 'fecha_pago'],
                ['data' => 'alumno_nombre', 'name' => 'alumno_nombre'],
                ['data' => 'tipo', 'name' => 'tipo', 'orderable' => false, 'searchable' => false],
                ['data' => 'monto', 'name' => 'monto'],
                ['data' => 'forma_pago', 'name' => 'forma_pago'],
                ['data' => 'descripcion', 'name' => 'descripcion'],
            ],
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            ]
        ];
        return view('reportes.pagos-realizados', compact('heads', 'config'));
    }

    public function pagosRealizadosData(Request $request)
    {
        // Obtener parámetros del request
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $formaPago = $request->input('forma_pago');

        // Si no hay fechas definidas, devolver colección vacía
        if (empty($fechaInicio) || empty($fechaFin)) {
            return DataTables::of(collect([]))
                ->addIndexColumn()
                ->make(true);
        }

        // Obtener pagos de inscripciones
        $pagosInscripciones = Pago::query()
            ->select(
                'pagos.id',
                'pagos.fecha_pago',
                'pagos.monto',
                'pagos.forma_pago',
                'pagos.descripcion',
                'alumnos.nombre as alumno_nombre',
                \DB::raw('"Inscripción" as tipo')
            )
            ->join('alumnos', 'pagos.alumno_id', '=', 'alumnos.id')
            ->whereBetween('pagos.fecha_pago', [$fechaInicio, $fechaFin . ' 23:59:59'])
            ->when(!empty($formaPago), function($query) use ($formaPago) {
                $query->where('pagos.forma_pago', $formaPago);
            });

        // Obtener pagos de matrículas
        $pagosMatriculas = PagoMatricula::query()
            ->select(
                'pagos_matriculas.id',
                'pagos_matriculas.fecha_pago',
                'pagos_matriculas.monto',
                'pagos_matriculas.forma_pago',
                'pagos_matriculas.descripcion',
                'alumnos.nombre as alumno_nombre',
                \DB::raw('"Matrícula" as tipo')
            )
            ->join('matriculas', 'pagos_matriculas.matricula_id', '=', 'matriculas.id')
            ->join('alumnos', 'matriculas.alumno_id', '=', 'alumnos.id')
            ->whereBetween('pagos_matriculas.fecha_pago', [$fechaInicio, $fechaFin . ' 23:59:59'])
            ->when(!empty($formaPago), function($query) use ($formaPago) {
                $query->where('pagos_matriculas.forma_pago', $formaPago);
            });

        // Obtener los resultados de ambas consultas
        $pagosInscripciones = $pagosInscripciones->get();
        $pagosMatriculas = $pagosMatriculas->get();

        // Combinar las colecciones
        $pagosCombinados = $pagosInscripciones->concat($pagosMatriculas);

        // Agregar un ID autoincremental a cada pago
        $pagosCombinados = $pagosCombinados->map(function ($item, $key) {
            $item->fila_id = $key + 1;
            $item->fecha_pago = Carbon::parse($item->fecha_pago)->format('d/m/Y');
            return $item;
        });

        // Crear una colección para DataTables
        return DataTables::of($pagosCombinados)
            ->addIndexColumn()
            ->make(true);
    }

    public function pagosrealizadosPDF(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $formaPago = $request->input('forma_pago');

        // Si no hay fechas definidas, devolver PDF vacío
        if (empty($fechaInicio) || empty($fechaFin)) {
            $pagos = collect([]);
            return view('reportes.pdf.pagos-realizados', compact('pagos', 'fechaInicio', 'fechaFin', 'formaPago'));
        }

        // Obtener pagos de inscripciones
        $pagosInscripciones = Pago::select(
                'pagos.id',
                'pagos.fecha_pago',
                'pagos.monto',
                'pagos.forma_pago',
                'pagos.descripcion',
                'alumnos.nombre as alumno_nombre',
                \DB::raw('"Inscripción" as tipo')
            )
            ->join('alumnos', 'pagos.alumno_id', '=', 'alumnos.id')
            ->whereBetween('pagos.fecha_pago', [$fechaInicio, $fechaFin . ' 23:59:59']);

        // Obtener pagos de matrículas
        $pagosMatriculas = PagoMatricula::query()
            ->select(
                'pagos_matriculas.id',
                'pagos_matriculas.fecha_pago',
                'pagos_matriculas.monto',
                'pagos_matriculas.forma_pago',
                'pagos_matriculas.descripcion',
                'alumnos.nombre as alumno_nombre',
                \DB::raw('"Matrícula" as tipo')
            )
            ->join('matriculas', 'pagos_matriculas.matricula_id', '=', 'matriculas.id')
            ->join('alumnos', 'matriculas.alumno_id', '=', 'alumnos.id')
            ->whereBetween('pagos_matriculas.fecha_pago', [$fechaInicio, $fechaFin . ' 23:59:59']);

        // Aplicar filtro de forma de pago si existe
        if (!empty($formaPago)) {
            $pagosInscripciones->where('pagos.forma_pago', $formaPago);
            $pagosMatriculas->where('pagos_matriculas.forma_pago', $formaPago);
        } else {
            $formaPago = 'Todos';
        }

        // Obtener y combinar resultados
        $pagosInscripciones = $pagosInscripciones->get();
        $pagosMatriculas = $pagosMatriculas->get();

        $pagos = $pagosInscripciones->concat($pagosMatriculas);

        // Agregar un ID autoincremental a cada pago
        $pagos = $pagos->map(function ($item, $key) {
            $item->fila_id = $key + 1;
            return $item;
        });

        $total = $pagos->sum('monto');

        $fechaInicio = Carbon::parse($fechaInicio)->format('d/m/Y');
        $fechaFin = Carbon::parse($fechaFin)->format('d/m/Y');

        $pdf = Pdf::loadView('reportes.pdf.pagos-realizados', compact('pagos', 'fechaInicio', 'fechaFin', 'formaPago', 'total'));
        return $pdf->stream('pagos-realizados.pdf');
    }

    public function alumnosConDeuda()
    {
        $heads = [
            'ID',
            'Alumno',
            'Concepto',
            'Tipo',
            'Monto Adeudado',
            'Último Pago'
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
                ['data' => 'fila_id', 'name' => 'fila_id'],
                ['data' => 'alumno_nombre', 'name' => 'alumno_nombre'],
                ['data' => 'concepto', 'name' => 'concepto'],
                ['data' => 'tipo', 'name' => 'tipo'],
                ['data' => 'monto', 'name' => 'monto', 'className' => 'text-end'],
                ['data' => 'descripcion', 'name' => 'descripcion']
            ],
            'order' => [[0, 'asc']], // Ordenar por monto descendente por defecto
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
        }, 'cursoCiclo.curso'])->get();

        // Obtener todas las matrículas con sus relaciones
        $matriculas = Matricula::with(['alumno', 'pagosMatriculas' => function($query) {
            $query->orderBy('fecha_pago', 'desc');
        }])->get();

        // Procesar inscripciones
        $deudasInscripciones = $inscripciones->map(function($inscripcion) {
            $tienePagos = $inscripcion->pagos->isNotEmpty();
            $totalPagado = $inscripcion->pagos->sum('monto');
            $deuda = $inscripcion->monto_total - $totalPagado;

            // Incluir si no tiene pagos o si tiene deuda
            if (!$tienePagos || $deuda > 0) {
                $ultimoPago = $inscripcion->pagos->first();

                return [
                    'alumno_nombre' => $inscripcion->alumno->nombre ?? 'Sin nombre',
                    'concepto' => 'Inscripción: ' . ($inscripcion->cursoCiclo->nombre ?? 'Curso no encontrado'),
                    'monto' => $deuda,
                    'monto_formateado' => number_format($deuda, 2) . ' Bs.',
                    'descripcion' => $tienePagos
                        ? 'Último pago: ' . ($ultimoPago->descripcion ?? '') . ($ultimoPago ? ' (' . $ultimoPago->fecha_pago . ')' : '')
                        : 'Sin pagos registrados',
                    'tipo' => 'Inscripción',
                    'deuda' => $deuda // Para ordenamiento
                ];
            }
            return null;
        })->filter();

        // Procesar matrículas
        $deudasMatriculas = $matriculas->map(function($matricula) {
            $tienePagos = $matricula->pagosMatriculas->isNotEmpty();
            $totalPagado = $matricula->pagosMatriculas->sum('monto');
            $deuda = $matricula->monto_total - $totalPagado;

            // Incluir si no tiene pagos o si tiene deuda
            if (!$tienePagos || $deuda > 0) {
                $ultimoPago = $matricula->pagosMatriculas->first();

                return [
                    'alumno_nombre' => $matricula->alumno->nombre ?? 'Sin nombre',
                    'concepto' => 'Matrícula Año: ' . $matricula->anio,
                    'monto' => $deuda,
                    'monto_formateado' => number_format($deuda, 2) . ' Bs.',
                    'descripcion' => $tienePagos
                        ? 'Último pago: ' . ($ultimoPago->descripcion ?? '') . ($ultimoPago ? ' (' . $ultimoPago->fecha_pago . ')' : '')
                        : 'Sin pagos registrados',
                    'tipo' => 'Matrícula',
                    'deuda' => $deuda // Para ordenamiento
                ];
            }
            return null;
        })->filter();

        // Combinar y ordenar resultados
        $resultados = $deudasInscripciones->concat($deudasMatriculas)
            ->sortByDesc('deuda')
            ->values()
            ->map(function($item) {
                return [
                    'alumno_nombre' => $item['alumno_nombre'],
                    'concepto' => $item['concepto'],
                    'monto' => $item['monto_formateado'],
                    'descripcion' => $item['descripcion'],
                    'tipo' => $item['tipo'],
                    'deuda' => $item['deuda']
                ];
            });

        $resultados = $deudasInscripciones->concat($deudasMatriculas)
            ->sortByDesc('deuda')
            ->values()
            ->map(function ($item, $key) {
                // Convertir a array si es un objeto
                $itemArray = is_array($item) ? $item : $item->toArray();
                // Agregar el ID de fila
                $itemArray['fila_id'] = $key + 1;
                return $itemArray;
            });

        return DataTables::of($resultados)
            ->addIndexColumn()
            ->make(true);
    }

    public function alumnosConDeudaPDF()
    {
        // Obtener todas las inscripciones con sus relaciones
        $inscripciones = Inscripcion::with(['alumno', 'pagos' => function($query) {
            $query->orderBy('fecha_pago', 'desc');
        }, 'cursoCiclo.curso'])->get();

        // Obtener todas las matrículas con sus relaciones
        $matriculas = Matricula::with(['alumno', 'pagosMatriculas' => function($query) {
            $query->orderBy('fecha_pago', 'desc');
        }])->get();

        // Procesar inscripciones
        $deudasInscripciones = $inscripciones->map(function($inscripcion) {
            $tienePagos = $inscripcion->pagos->isNotEmpty();
            $totalPagado = $inscripcion->pagos->sum('monto');
            $deuda = $inscripcion->monto_total - $totalPagado;

            if (!$tienePagos || $deuda > 0) {
                $ultimoPago = $inscripcion->pagos->first();

                return [
                    'alumno_nombre' => $inscripcion->alumno->nombre ?? 'Sin nombre',
                    'concepto' => 'Inscripción: ' . ($inscripcion->cursoCiclo->nombre ?? 'Curso no encontrado'),
                    'monto' => number_format($deuda, 2) . ' Bs.',
                    'descripcion' => $tienePagos
                        ? 'Último pago: ' . ($ultimoPago->descripcion ?? '') . ($ultimoPago ? ' (' . $ultimoPago->fecha_pago . ')' : '')
                        : 'Sin pagos registrados',
                    'tipo' => 'Inscripción',
                    'deuda' => $deuda
                ];
            }
            return null;
        })->filter();

        // Procesar matrículas
        $deudasMatriculas = $matriculas->map(function($matricula) {
            $tienePagos = $matricula->pagosMatriculas->isNotEmpty();
            $totalPagado = $matricula->pagosMatriculas->sum('monto');
            $deuda = $matricula->monto_total - $totalPagado;

            if (!$tienePagos || $deuda > 0) {
                $ultimoPago = $matricula->pagosMatriculas->first();

                return [
                    'alumno_nombre' => $matricula->alumno->nombre ?? 'Sin nombre',
                    'concepto' => 'Matrícula Año: ' . $matricula->anio,
                    'monto' => number_format($deuda, 2) . ' Bs.',
                    'descripcion' => $tienePagos
                        ? 'Último pago: ' . ($ultimoPago->descripcion ?? '') . ($ultimoPago ? ' (' . $ultimoPago->fecha_pago . ')' : '')
                        : 'Sin pagos registrados',
                    'tipo' => 'Matrícula',
                    'deuda' => $deuda
                ];
            }
            return null;
        })->filter();

        // Combinar y ordenar resultados
        $resultados = $deudasInscripciones->concat($deudasMatriculas)
            ->sortByDesc('deuda')
            ->values()
            ->map(function ($item, $key) {
                // Convertir a array si es un objeto
                $itemArray = is_array($item) ? $item : $item->toArray();
                // Agregar el ID de fila
                $itemArray['fila_id'] = $key + 1;
                return $itemArray;
            });

        $totalDeuda = $resultados->sum('deuda');

        $pdf = Pdf::loadView('reportes.pdf.alumnos-con-deuda', compact('resultados', 'totalDeuda'));
        return $pdf->stream();
    }

    public function planillas()
    {
        $cursosCiclos = CursoCiclo::where('estado', 'activo')->get();

        $calificacionesHeads = [
            'Inscripción',
            'Examen 1',
            'Examen 2',
            'Nota Final'
        ];

        $inscripcionesHeads = [
            'Alumno',
            'Curso',
            'Fecha Inicio',
            'Fecha Fin'
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
                ['data' => 'examen_1', 'name' => 'examen_1'],
                ['data' => 'examen_2', 'name' => 'examen_2'],
                ['data' => 'nota_final', 'name' => 'nota_final']
            ],
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            ]
        ];

        $inscripcionesConfig = [
            'processing' => true,
            'serverSide' => true,
            'ajax' => [
                'url' => route('reportes.planillas.inscripciones.data'),
                'type' => 'GET',
                'dataSrc' => 'data'
            ],
            'columns' => [
                ['data' => 'alumno_nombre', 'name' => 'alumno_nombre'],
                ['data' => 'curso', 'name' => 'curso'],
                ['data' => 'fecha_inicio', 'name' => 'fecha_inicio'],
                ['data' => 'fecha_fin', 'name' => 'fecha_fin']
            ],
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            ]
        ];

        return view('reportes.planillas', compact('cursosCiclos', 'calificacionesHeads', 'calificacionesConfig', 'inscripcionesHeads', 'inscripcionesConfig'));
    }

    public function planillasInscripcionesData(Request $request)
    {
        $cursoCiclo = $request->curso_ciclo;

        $inscripciones = Inscripcion::whereHas('cursoCiclo', function ($query) use ($cursoCiclo) {
            $query->where('id', $cursoCiclo);
        })
            ->get();

        return DataTables::of($inscripciones)
            ->addColumn('alumno_nombre', function ($inscripcion) {
                return $inscripcion->alumno->nombre ?? '';
            })
            ->addColumn('curso', function ($inscripcion) {
                return $inscripcion->cursoCiclo->nombre ?? '';
            })
            ->addColumn('fecha_inicio', function ($inscripcion) {
                return Carbon::parse($inscripcion->cursoCiclo->fecha_inicio)->format('d/m/Y');
            })
            ->addColumn('fecha_fin', function ($inscripcion) {
                return Carbon::parse($inscripcion->cursoCiclo->fecha_fin)->format('d/m/Y');
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function planillasCalificacionesData(Request $request)
    {
        $cursoCiclo = $request->curso_ciclo;

        if (!empty($cursoCiclo)) {
            $calificaciones = Calificacion::whereHas('inscripcion', function ($query) use ($cursoCiclo) {
                $query->whereHas('cursoCiclo', function ($query) use ($cursoCiclo) {
                    $query->where('id', $cursoCiclo);
                });
            })
            ->get();
        } else {
            $calificaciones = Calificacion::whereRaw('1 = 0');
        }

        return DataTables::of($calificaciones)
            ->addColumn('inscripcion_nombre', function ($calificacion) {
                return $calificacion->inscripcion->alumno->nombre . ' - (' . $calificacion->inscripcion->cursoCiclo->nombre . ')' . ' ['. Carbon::parse($calificacion->inscripcion->cursoCiclo->fecha_inicio)->format('d/m/Y') . ' - '. Carbon::parse($calificacion->inscripcion->cursoCiclo->fecha_fin)->format('d/m/Y') . ']' ?? '';
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
