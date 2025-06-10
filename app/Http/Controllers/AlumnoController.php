<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\AlumnoRequest;
use Yajra\DataTables\DataTables;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heads = [
            'ID',
            'Nombre',
            'Fecha de Nacimiento',
            'Usuario',
            'Estado',
            ['label' => 'Acciones', 'no-export' => true, 'orderable' => false, 'searchable' => false],
        ];

        $config = [
            'processing' => true,
            'serverSide' => true,
            'ajax' => [
                'url' => route('alumnos.data'),
                'type' => 'GET',
                'dataSrc' => 'data'
            ],
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'nombre', 'name' => 'nombre'],
                ['data' => 'fecha_nacimiento', 'name' => 'fecha_nacimiento'],
                ['data' => 'nombre_usuario', 'name' => 'nombre_usuario'],
                ['data' => 'estado', 'name' => 'estado'],
                ['data' => 'actions', 'name' => 'actions', 'orderable' => false, 'searchable' => false]
            ],
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            ]
        ];

        return view('alumnos.index', compact('heads', 'config'));
    }

    public function data()
    {
        return Datatables::of(Alumno::with('user'))
            ->addColumn('nombre_usuario', fn ($alumno) => $alumno->user->username ?? '')
            ->addColumn('estado', function ($alumno) {
                if ($alumno->estado == 'activo') {
                    return '<span class="badge badge-success">Activo</span>';
                } else {
                    return '<span class="badge badge-secondary">Inactivo</span>';
                }
            })
            ->addColumn('actions', function ($alumno) {
                return view('alumnos.partials._actions', compact('alumno'))->render();
            })
            ->rawColumns(['estado', 'actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = User::where('role', 'alumno')->get();
        return view('alumnos.create', compact('usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AlumnoRequest $request)
    {
        Alumno::create($request->validated());

        return redirect()
            ->route('alumnos.index')
            ->with('success', 'Alumno creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Alumno $alumno)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alumno $alumno)
    {
        $usuarios = User::where('role', 'alumno')->get();
        return view('alumnos.edit', compact('alumno', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AlumnoRequest $request, Alumno $alumno)
    {
        $alumno->update($request->validated());

        return redirect()
            ->route('alumnos.index')
            ->with('success', 'Alumno actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alumno $alumno)
    {
        if ($alumno->estado == 'activo') {
            $alumno->update(['estado' => 'inactivo']);
            $title = 'Desactivar';
            $message = 'El Alumno ha sido desactivado correctamente';
        } else {
            $alumno->update(['estado' => 'activo']);
            $title = 'Activar';
            $message = 'El Alumno ha sido activado correctamente';
        }

        return response()->json([
            'success' => true,
            'title' => $title,
            'message' => $message
        ]);
    }
}
