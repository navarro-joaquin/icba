<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\CursoCiclo;
use App\Models\Pago;
use App\Models\Alumno;
use App\Http\Requests\InscripcionRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class InscripcionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heads = [
            'ID',
            'Alumno',
            'Curso-Ciclo',
            'Fecha de inscripción',
            'Monto total (Bs.)',
            'Estado',
            ['label' => 'Acciones', 'no-export' => true, 'orderable' => false, 'searchable' => false],
        ];

        $config = [
            'processing' => true,
            'serverSide' => true,
            'ajax' => [
                'url' => route('inscripciones.data'),
                'type' => 'GET',
                'dataSrc' => 'data'
            ],
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'alumno_nombre', 'name' => 'alumno_nombre'],
                ['data' => 'curso_ciclo_nombre', 'name' => 'curso_ciclo_nombre'],
                ['data' => 'fecha_inscripcion', 'name' => 'fecha_inscripcion'],
                ['data' => 'monto_total', 'name' => 'monto_total'],
                ['data' => 'estado', 'name' => 'estado'],
                ['data' => 'actions', 'name' => 'actions', 'orderable' => false, 'searchable' => false],
            ],
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            ]
        ];

        return view('inscripciones.index', compact('heads', 'config'));
    }

    public function data()
    {
        $user = auth()->user();

        if ($user->hasRole('alumno')) {
            $query = Inscripcion::with('alumno', 'cursoCiclo')->where('alumno_id', $user->alumno->id)->get();
        } else {
            $query = Inscripcion::with('alumno', 'cursoCiclo')->get();
        }

        return DataTables::of($query)
            ->addColumn('alumno_nombre', fn ($inscripcion) => $inscripcion->alumno->nombre ?? '')
            ->addColumn('curso_ciclo_nombre', fn ($inscripcion) => $inscripcion->cursoCiclo->nombre ?? '')
            ->addColumn('estado', function ($inscripcion) {
                return match ($inscripcion->estado) {
                    'activo' => '<span class="badge bg-success">Activo</span>',
                    'inactivo' => '<span class="badge bg-secondary">Inactivo</span>',
                    default => '<span class="badge bg-danger">Cancelada</span>',
                };
            })
            ->addColumn('actions', function ($inscripcion) {
                return view('inscripciones.partials._actions', compact('inscripcion'))->render();
            })
            ->rawColumns(['estado', 'actions'])
            ->make(true);
    }

    public function obtener($alumno_id)
    {
        // Obtener IDs de inscripciones que ya tienen pagos completados
        $inscripciones_pagadas = Pago::select('inscripcion_id')
            ->groupBy('inscripcion_id')
            ->havingRaw('SUM(monto) >= (SELECT monto_total FROM inscripciones WHERE id = inscripcion_id)')
            ->pluck('inscripcion_id')
            ->toArray();

        $inscripciones = Inscripcion::with('cursoCiclo')
            ->where('alumno_id', $alumno_id)
            ->where('estado', 'activo')
            ->whereNotIn('id', $inscripciones_pagadas)
            ->get();

        if ($inscripciones->isEmpty()) {
            return response()->json(['inscripciones' => []]);
        }

        return response()->json(['inscripciones' => $inscripciones]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cursosCiclos = CursoCiclo::where('estado', 'activo')->get();
        $alumnos = Alumno::where('estado', 'activo')->get();

        return view('inscripciones.create', compact('cursosCiclos', 'alumnos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InscripcionRequest $request)
    {
        Inscripcion::create($request->validated());

        return redirect()
            ->route('inscripciones.index')
            ->with('success', 'Inscripción creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inscripcion $inscripcion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inscripcion $inscripcion)
    {
        $cursosCiclos = CursoCiclo::where('estado', 'activo')->get();
        $alumnos = Alumno::where('estado', 'activo')->get();

        return view('inscripciones.edit', compact('inscripcion', 'cursosCiclos', 'alumnos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InscripcionRequest $request, Inscripcion $inscripcion)
    {
        $inscripcion->update($request->validated());

        return redirect()
            ->route('inscripciones.index')
            ->with('success', 'Inscripción actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inscripcion $inscripcion)
    {
        if ($inscripcion->estado == 'activo') {
            $inscripcion->update(['estado' => 'inactivo']);
            $title = 'Desactivar';
            $message = 'Inscripción desactivada correctamente';
        } else {
            $inscripcion->update(['estado' => 'activo']);
            $title = 'Activar';
            $message = 'Inscripción activada correctamente';
        }

        return response()->json([
            'success' => true,
            'title' => $title,
            'message' => $message
        ]);
    }
}
