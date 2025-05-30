<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('alumnos.index');
    }

    public function data()
    {
        return Datatables::of(Alumno::with('user'))
            ->addColumn('nombre_usuario', fn($alumno) => $alumno->user->username ?? '')
            ->addColumn('actions', function($alumno) {
                return view('alumnos.partials._actions', compact('alumno'))->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = User::all();
        return view('alumnos.create', compact('usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string',
            'fecha_nacimiento' => 'required|date',
            'user_id' => 'required|exists:users,id'
        ]);

        Alumno::create($validated);

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
        $usuarios = User::all();
        return view('alumnos.edit', compact('alumno', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alumno $alumno)
    {
        $validated = $request->validate([
            'nombre' => 'required|string',
            'fecha_nacimiento' => 'required|date',
            'user_id' => 'required|exists:users,id'
        ]);

        $alumno->update($validated);

        return redirect()
            ->route('alumnos.index')
            ->with('success', 'Alumno actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alumno $alumno)
    {
        $alumno->delete();

        return response()->json([
            'success' => true,
            'message' => 'Alumno eliminado correctamente'
        ]);
    }
}
