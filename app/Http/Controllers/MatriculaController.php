<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\PagoMatricula;
use App\Models\Alumno;
use Illuminate\Http\Request;
use App\Http\Requests\MatriculaRequest;
use Yajra\DataTables\DataTables;

class MatriculaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heads = [
            'ID',
            'Alumno',
            'Año',
            'Monto Total a pagar (Bs.)',
            'Estado',
            ['label' => 'Acciones', 'no-export' => true, 'orderable' => false, 'searchable' => false],
        ];

        $config = [
            'processing' => true,
            'serverSide' => true,
            'ajax' => [
                'url' => route('matriculas.data'),
                'type' => 'GET',
                'dataSrc' => 'data'
            ],
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'alumno_nombre', 'name' => 'alumno_nombre'],
                ['data' => 'anio', 'name' => 'anio'],
                ['data' => 'monto_total', 'name' => 'monto_total'],
                ['data' => 'estado', 'name' => 'estado'],
                ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false]
            ],
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            ]
        ];

        return view('matriculas.index', compact('heads', 'config'));
    }

    public function data()
    {
        $user = auth()->user();

        if ($user->hasRole('alumno')) {
            $query = Matricula::with('alumno')->where('alumno_id', $user->alumno->id)->get();
        } else {
            $query = Matricula::with('alumno')->get();
        }

        return DataTables::of($query)
            ->addColumn('alumno_nombre', fn ($matricula) => $matricula->alumno->nombre ?? '')
            ->addColumn('estado', function ($matricula) {
                return match ($matricula->estado) {
                    'pendiente' => '<span class="badge bg-secondary">Pendiente</span>',
                    'pagada' => '<span class="badge bg-success">Pagada</span>',
                    default => '<span class="badge bg-danger">Cancelada</span>',
                };
            })
            ->addColumn('actions', function ($matricula) {
                return view('matriculas.partials._actions', compact('matricula'))->render();
            })
            ->rawColumns(['estado', 'actions'])
            ->make(true);
    }

    public function estado($alumno_id)
    {
        $anioActual = now()->year;

        $matricula = Matricula::where('alumno_id', $alumno_id)
            ->where('anio', $anioActual)
            ->first();

        if (!$matricula) {
            return response()->json([
                'estado' => 'no_registrada',
                'anio' => $anioActual,
            ]);
        }

        $pagado = $matricula->pagosMatriculas()->sum('monto');
        $completo = $pagado >= $matricula->monto_total;

        return response()->json([
            'estado' => $completo ? 'pagada' : 'pendiente',
            'pagado' => $pagado,
            'total' => $matricula->monto_total,
            'anio' => $matricula->anio,
        ]);
    }

    public function obtener($alumno_id)
    {
        // Obtener IDs de matrículas que ya tienen pagos completados
        $matriculas_pagadas = PagoMatricula::select('matricula_id')
            ->groupBy('matricula_id')
            ->havingRaw('SUM(monto) >= (SELECT monto_total FROM matriculas WHERE id = matricula_id)')
            ->pluck('matricula_id')
            ->toArray();

        $matriculas = Matricula::where('alumno_id', $alumno_id)
            ->where('estado', 'pendiente')
            ->whereNotIn('id', $matriculas_pagadas)
            ->get();

        if ($matriculas->isEmpty()) {
            return response()->json(['matriculas' => []]);
        }

        return response()->json(['matriculas' => $matriculas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $anio_actual = date('Y');

        // Obtener IDs de alumnos que ya tienen matrícula para el año actual
        $alumnos_con_matricula = Matricula::where('anio', $anio_actual)
            ->pluck('alumno_id')
            ->toArray();

        // Obtener alumnos activos que no tengan matrícula para el año actual
        $alumnos = Alumno::where('estado', 'activo')
            ->whereNotIn('id', $alumnos_con_matricula)
            ->get();

        return view('matriculas.create', compact('alumnos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MatriculaRequest $request)
    {
        $validatedData = $request->validated();

        Matricula::create($validatedData);

        return redirect()
            ->route('matriculas.index')
            ->with('success', 'Matricula creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Matricula $matricula)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Matricula $matricula)
    {
        $alumnos = Alumno::where('estado', 'activo')->get();

        return view('matriculas.edit', compact('matricula', 'alumnos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MatriculaRequest $request, Matricula $matricula)
    {
        $validatedData = $request->validated();

        $matricula->update($validatedData);

        return redirect()
            ->route('matriculas.index')
            ->with('success', 'Matricula actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matricula $matricula)
    {
        //
    }
}
