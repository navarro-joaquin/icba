<?php

namespace App\Http\Controllers;

use App\Models\PagoMatricula;
use App\Models\Alumno;
use App\Models\Matricula;
use App\Http\Requests\PagoMatriculaRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PagoMatriculaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heads = [
            'ID',
            'Alumno',
            'Matricula',
            'Fecha de pago',
            'Monto',
            'Forma de Pago',
            'Descripción',
            ['label' => 'Acciones', 'no-export' => true, 'orderable' => false, 'searchable' => false]
        ];

        $config = [
            'processing' => true,
            'serverSide' => true,
            'ajax' => [
                'url' => route('pagos-matriculas.data'),
                'type' => 'GET',
                'dataSrc' => 'data'
            ],
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'alumno_nombre', 'name' => 'alumno_nombre'],
                ['data' => 'matricula_nombre', 'name' => 'matricula_nombre'],
                ['data' => 'fecha_pago', 'name' => 'fecha_pago'],
                ['data' => 'monto', 'name' => 'monto'],
                ['data' => 'forma_pago', 'name' => 'forma_pago'],
                ['data' => 'descripcion', 'name' => 'descripcion'],
                ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false]
            ],
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            ]
        ];

        return view('pagos-matriculas.index', compact('heads', 'config'));
    }

    public function data()
    {
        $user = auth()->user();

        if ($user->hasRole('alumno')) {
            $query = PagoMatricula::with('alumno', 'matricula')->where('alumno_id', $user->alumno->id)->get();
        } else {
            $query = PagoMatricula::with('alumno', 'matricula')->get();
        }

        return DataTables::of($query)
            ->addColumn('alumno_nombre', fn ($pago_matricula) => $pago_matricula->alumno->nombre ?? '')
            ->addColumn('matricula_nombre', fn ($pago_matricula) => $pago_matricula->matricula->anio ?? '')
            ->addColumn('forma_pago', function ($pago_matricula) {
                return match ($pago_matricula->forma_pago) {
                    'efectivo' => 'Efectivo',
                    'transferencia' => 'Transferencia',
                    default => 'Otro',
                };
            })
            ->addColumn('actions', function ($pago_matricula) {
                return view('pagos-matriculas.partials._actions', compact('pago_matricula'))->render();
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
        $matriculas = Matricula::where('estado', 'activo')->get();

        return view('pagos-matriculas.create', compact('alumnos', 'matriculas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PagoMatriculaRequest $request)
    {
        PagoMatricula::create($request->validated());

        return redirect()
            ->route('pagos-matriculas.index')
            ->with('success', 'Pago de matricula creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(PagoMatricula $pago_matricula)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PagoMatricula $pago_matricula)
    {
        $alumnos = Alumno::where('estado', 'activo')->get();
        $matriculas = Matricula::where('estado', 'activo')->get();

        return view('pagos-matriculas.edit', compact('pago_matricula', 'alumnos', 'matriculas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PagoMatriculaRequest $request, PagoMatricula $pago_matricula)
    {
        $pago_matricula->update($request->validated());

        return redirect()
            ->route('pagos-matriculas.index')
            ->with('success', 'Pago de matricula actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PagoMatricula $pago_matricula)
    {
        $pago_matricula->delete();

        return response()->json([
            'success' => true,
            'title' => 'Eliminado',
            'message' => 'Pago de matricula eliminado correctamente'
        ]);
    }
}
