<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
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
            'Monto Total (Bs.)',
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
        $query = Matricula::query();

        return DataTables::of($query)
            ->addColumn('alumno_nombre', fn ($matricula) => $matricula->alumno->nombre ?? '')
            ->addColumn('estado', function ($matricula) {
                return match ($matricula->estado) {
                    'activo' => '<span class="badge bg-success">Activo</span>',
                    'inactivo' => '<span class="badge bg-secondary">Inactivo</span>',
                    default => '<span class="badge bg-danger">Cancelada</span>',
                };
            })
            ->addColumn('actions', function ($matricula) {
                return view('matriculas.partials._actions', compact('matricula'))->render();
            })
            ->rawColumns(['estado', 'actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $alumnos = Alumno::where('estado', 'activo')->get();

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
