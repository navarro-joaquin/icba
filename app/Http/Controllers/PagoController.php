<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Alumno;
use App\Models\Inscripcion;
use App\Http\Requests\PagoRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heads = [
            'ID',
            'Alumno',
            'Inscripción',
            'Fecha de pago',
            'Monto',
            'Descripción',
            ['label' => 'Acciones', 'no-export' => true, 'orderable' => false, 'searchable' => false]
        ];

        $config = [
            'processing' => true,
            'serverSide' => true,
            'ajax' => [
                'url' => route('pagos.data'),
                'type' => 'GET',
                'dataSrc' => 'data'
            ],
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'alumno_nombre', 'name' => 'alumno_nombre'],
                ['data' => 'inscripcion_nombre', 'name' => 'inscripcion_nombre'],
                ['data' => 'fecha_pago', 'name' => 'fecha_pago'],
                ['data' => 'monto', 'name' => 'monto'],
                ['data' => 'descripcion', 'name' => 'descripcion'],
                ['data' => 'actions', 'name' => 'actions', 'orderable' => false, 'searchable' => false],
            ],
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            ]
        ];

        return view('pagos.index', compact('heads', 'config'));
    }

    public function data()
    {
        $query = Pago::query();

        return DataTables::of($query)
            ->addColumn('alumno_nombre', fn ($pago) => $pago->alumno->nombre ?? '')
            ->addColumn('inscripcion_nombre', fn ($pago) => $pago->inscripcion->curso_gestion->nombre ?? '')
            ->addColumn('actions', function ($pago) {
                return view('pagos.partials._actions', compact('pago'))->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $alumnos = Alumno::where('estado', 'activo')->get();
        $inscripciones = Inscripcion::where('estado', 'activo')->get();

        return view('pagos.create', compact('alumnos', 'inscripciones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PagoRequest $request)
    {
        Pago::create($request->validated());

        return redirect()
            ->route('pagos.index')
            ->with('success', 'Pago creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pago $pago)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pago $pago)
    {
        $alumnos = Alumno::where('estado', 'activo')->get();
        $inscripciones = Inscripcion::where('estado', 'activo')->get();

        return view('pagos.edit', compact('pago', 'alumnos', 'inscripciones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PagoRequest $request, Pago $pago)
    {
        $pago->update($request->validated());

        return redirect()
            ->route('pagos.index')
            ->with('success', 'Pago actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pago $pago)
    {
        $pago->delete();

        return response()->json([
            'success' => true,
            'title' => 'Eliminado',
            'message' => 'Pago eliminado correctamente'
        ]);
    }
}
