<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\CursoGestion;
use App\Http\Requests\ClaseRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ClaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heads = [
            'ID',
            'Curso y Gestión',
            'Número de clase',
            'Fecha de clase',
            'Tema',
            ['label' => 'Acciones', 'no-export' => true, 'orderable' => false, 'searchable' => false],
        ];

        $config = [
            'processing' => true,
            'serverSide' => true,
            'ajax' => [
                'url' => route('clases.data'),
                'type' => 'GET',
                'dataSrc' => 'data'
            ],
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'curso_gestion_nombre', 'name' => 'curso_gestion_nombre'],
                ['data' => 'numero_clase', 'name' => 'numero_clase'],
                ['data' => 'fecha_clase', 'name' => 'fecha_clase'],
                ['data' => 'tema', 'name' => 'tema'],
                ['data' => 'actions', 'name' => 'actions', 'orderable' => false, 'searchable' => false],
            ],
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            ]
        ];

        return view('clases.index', compact('heads', 'config'));
    }

    public function data()
    {
        $query = Clase::query();

        return DataTables::of($query)
            ->addColumn('curso_gestion_nombre', fn ($clase) => $clase->cursoGestion->nombre ?? '')
            ->addColumn('actions', function ($clase) {
                return view('clases.partials._actions', compact('clase'))->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cursosGestiones = CursoGestion::where('estado', 'activo')->get();

        return view('clases.create', compact('cursosGestiones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClaseRequest $request)
    {
        Clase::create($request->validated());

        return redirect()
            ->route('clases.index')
            ->with('success', 'Clase creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Clase $clase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Clase $clase)
    {
        $cursosGestiones = CursoGestion::where('estado', 'activo')->get();

        return view('clases.edit', compact('clase', 'cursosGestiones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClaseRequest $request, Clase $clase)
    {
        $clase->update($request->validated());

        return redirect()
            ->route('clases.index')
            ->with('success', 'Clase actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clase $clase)
    {
        $clase->delete();

        return response()->json([
            'success' => true,
            'title' => 'Eliminado',
            'message' => 'Clase eliminada correctamente'
        ]);
    }
}
