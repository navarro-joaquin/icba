<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscripcion;
use App\Models\Pago;
use App\Models\Calificacion;
use App\Models\CursoCiclo;
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
        }, 'cursoCiclo.curso'])->get();

        $resultados = $inscripciones->map(function($inscripcion) {
            $tienePagos = $inscripcion->pagos->isNotEmpty();
            $totalPagado = $inscripcion->pagos->sum('monto');
            $deuda = $inscripcion->monto_total - $totalPagado;

            // Incluir si no tiene pagos o si tiene deuda
            if (!$tienePagos || $deuda > 0) {
                $ultimoPago = $inscripcion->pagos->first();

                return [
                    'alumno_nombre' => $inscripcion->alumno->nombre ?? 'Sin nombre',
                    'inscripcion' => 'Inscripción al Curso: ' . ($inscripcion->cursoCiclo->nombre ?? 'Curso no encontrado'),
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
        }, 'cursoCiclo.curso'])->get();

        $resultados = $inscripciones->map(function($inscripcion) {
            $tienePagos = $inscripcion->pagos->isNotEmpty();
            $totalPagado = $inscripcion->pagos->sum('monto');
            $deuda = $inscripcion->monto_total - $totalPagado;

            // Incluir si no tiene pagos o si tiene deuda
            if (!$tienePagos || $deuda > 0) {
                $ultimoPago = $inscripcion->pagos->first();

                return [
                    'alumno_nombre' => $inscripcion->alumno->nombre ?? 'Sin nombre',
                    'inscripcion' => 'Inscripción al Curso: ' . ($inscripcion->cursoCiclo->nombre ?? 'Curso no encontrado'),
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
        $cursosCiclos = CursoCiclo::where('estado', 'activo')->get();

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

        return view('reportes.planillas', compact('cursosCiclos', 'calificacionesHeads', 'calificacionesConfig'));
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
                return $calificacion->inscripcion->alumno->nombre . ' - (' . $calificacion->inscripcion->cursoCiclo->nombre . ')' . ' ('. $calificacion->inscripcion->cursoCiclo->fecha_inicio . ' - '. $calificacion->inscripcion->cursoCiclo->fecha_fin . ')' ?? '';
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
