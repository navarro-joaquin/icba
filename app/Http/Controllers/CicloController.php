<?php

namespace App\Http\Controllers;

use App\Models\Ciclo;
use App\Http\Requests\CicloRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class CicloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heads = [
            'ID',
            'Nombre',
            'Fecha de inicio',
            'Fecha de finalización',
            'Estado',
            ['label' => 'Acciones', 'no-export' => true, 'searchable' => false, 'orderable' => false],
        ];

        $config = [
            'processing' => true,
            'serverSide' => true,
            'ajax' => [
                'url' => route('ciclos.data'),
                'type' => 'GET',
                'dataSrc' => 'data'
            ],
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'nombre', 'name' => 'nombre'],
                ['data' => 'fecha_inicio', 'name' => 'fecha_inicio'],
                ['data' => 'fecha_fin', 'name' => 'fecha_fin'],
                ['data' => 'estado', 'name' => 'estado'],
                ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false],
            ],
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            ]
        ];

        return view('ciclos.index', compact('heads', 'config'));
    }

    public function data()
    {
        $query = Ciclo::query();

        return DataTables::of($query)
            ->addColumn('fecha_inicio', fn ($ciclo) => Carbon::parse($ciclo->fecha_inicio)->format('d/m/Y'))
            ->addColumn('fecha_fin', fn ($ciclo) => Carbon::parse($ciclo->fecha_fin)->format('d/m/Y'))
            ->addColumn('estado', function ($ciclo) {
                return match ($ciclo->estado) {
                    'activo' => '<span class="badge bg-success">Activo</span>',
                    'inactivo' => '<span class="badge bg-secondary">Inactivo</span>',
                    default => '<span class="badge bg-danger">Cancelado</span>',
                };
            })
            ->addColumn('actions', function ($ciclo) {
                return view('ciclos.partials._actions', compact('ciclo'))->render();
            })
            ->rawColumns(['estado', 'actions'])
            ->make(true);
    }

    public function fechas($id) {
        $ciclo = Ciclo::findOrFail($id);

        return response()->json([
            'fecha_inicio' => $ciclo->fecha_inicio,
            'fecha_fin' => $ciclo->fecha_fin,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ciclos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CicloRequest $request)
    {
        Ciclo::create($request->validated());

        return redirect()
            ->route('ciclos.index')
            ->with('success', 'Ciclo creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ciclo $ciclo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ciclo $ciclo)
    {
        return view('ciclos.edit', compact('ciclo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CicloRequest $request, Ciclo $ciclo)
    {
        $ciclo->update($request->validated());

        return redirect()
            ->route('ciclos.index')
            ->with('success', 'Ciclo actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ciclo $ciclo)
    {
        if ($ciclo->estado == 'activo') {
            $ciclo->update(['estado' => 'inactivo']);
            $title = 'Desactivar';
            $message = 'El ciclo ha sido desactivado correctamente';
        } else {
            $ciclo->update(['estado' => 'activo']);
            $title = 'Activar';
            $message = 'El ciclo ha sido activado correctamente';
        }

        return response()->json([
            'success' => true,
            'title' => $title,
            'message' => $message
        ]);
    }
}
