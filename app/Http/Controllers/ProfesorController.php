<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use App\Models\User;
use App\Http\Requests\ProfesorRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProfesorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heads = [
            'ID',
            'Nombre',
            'Especialidad',
            'Usuario',
            'Estado',
            ['label' => 'Acciones', 'no-export' => true, 'searchable' => false, 'orderable' => false]
        ];

        $config = [
            'processing' => true,
            'serverSide' => true,
            'ajax' => [
                'url' => route('profesores.data'),
                'type' => 'GET',
                'dataSrc' => 'data'
            ],
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'nombre', 'name' => 'nombre'],
                ['data' => 'especialidad', 'name' => 'especialidad'],
                ['data' => 'nombre_usuario', 'name' => 'nombre_usuario'],
                ['data' => 'estado', 'name' => 'estado'],
                ['data' => 'actions', 'name' => 'actions', 'orderable' => false, 'searchable' => false],
            ],
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            ]
        ];

        return view('profesores.index', compact('heads', 'config'));
    }

    public function data()
    {
        $query = Profesor::query();

        return DataTables::of($query)
            ->addColumn('nombre_usuario', fn ($profesor) => $profesor->user->username ?? '')
            ->addColumn('estado', function ($profesor) {
                if ($profesor->estado == 'activo') {
                    return '<span class="badge badge-success">Activo</span>';
                } else {
                    return '<span class="badge badge-secondary">Inactivo</span>';
                }
            })
            ->addColumn('actions', function ($profesor) {
                return view('profesores.partials._actions', compact('profesor'))->render();
            })
            ->rawColumns(['estado', 'actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = User::where('role', 'profesor')
            ->where('status', 'active')
            ->whereDoesntHave('profesor')
            ->get();
        return view('profesores.create', compact('usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProfesorRequest $request)
    {
        Profesor::create($request->validated());

        return redirect()
            ->route('profesores.index')
            ->with('success', 'Profesor creado correctmente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Profesor $profesor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profesor $profesor)
    {
        $usuarios = User::where('role', 'profesor')
            ->where('status', 'active')
            ->where(function ($query) use ($profesor) {
                $query->whereDoesntHave('profesor')
                    ->orWhere('id', $profesor->user_id);
            })
            ->get();
        return view('profesores.edit', compact('usuarios', 'profesor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfesorRequest $request, Profesor $profesor)
    {
        $profesor->update($request->validated());

        return redirect()
            ->route('profesores.index')
            ->with('success', 'Profesor actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profesor $profesor)
    {
        if ($profesor->estado == 'activo') {
            $profesor->update(['estado' => 'inactivo']);
            $title = 'Desactivar';
            $message = 'El profesor ha sido desactivado correctamente';
        } else {
            $profesor->update(['estado' => 'activo']);
            $title = 'Activar';
            $message = 'El profesor ha sido activado correctamente';
        }

        return response()->json([
            'success' => true,
            'title' => $title,
            'message' => $message
        ]);
    }
}
