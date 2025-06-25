<?php

namespace App\Http\Controllers;

use App\Models\Gestion;
use App\Http\Requests\GestionRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class GestionController extends Controller
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
                'url' => route('gestiones.data'),
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

        return view('gestiones.index', compact('heads', 'config'));
    }

    public function data()
    {
        $query = Gestion::query();

        return DataTables::of($query)
            ->addColumn('estado', function ($gestion) {
                if ($gestion->estado == 'activo') {
                    return '<span class="badge badge-success">Activo</span>';
                } else {
                    return '<span class="badge badge-secondary">Inactivo</span>';
                }
            })
            ->addColumn('actions', function ($gestion) {
                return view('gestiones.partials._actions', compact('gestion'))->render();
            })
            ->rawColumns(['estado', 'actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gestiones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GestionRequest $request)
    {
        Gestion::create($request->validated());

        return redirect()
            ->route('gestiones.index')
            ->with('success', 'Gestión creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gestion $gestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gestion $gestion)
    {
        return view('gestiones.edit', compact('gestion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GestionRequest $request, Gestion $gestion)
    {
        $gestion->update($request->validated());

        return redirect()
            ->route('gestiones.index')
            ->with('success', 'Gestión actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gestion $gestion)
    {
        if ($gestion->estado == 'activo') {
            $gestion->update(['estado' => 'inactivo']);
            $title = 'Desactivar';
            $message = 'La gestión ha sido desactivada correctamente';
        } else {
            $gestion->update(['estado' => 'activo']);
            $title = 'Activar';
            $message = 'La gesti[on ha sido activada correctamente';
        }

        return response()->json([
            'success' => true,
            'title' => $title,
            'message' => $message
        ]);
    }
}
