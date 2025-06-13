<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Inscripcion;
use App\Models\Clase;
use App\Http\Requests\AsistenciaRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heads = [
            'ID',
            'Inscripcion',
            'Clase',
            'Presente',
            ['label' => 'Acciones', 'no-export' => true, 'searchable' => false, 'orderable' => false],
        ];

        $config = [
            'processing' => true,
            'serverSide' => true,
            'ajax' => [
                'url' => route('asistencias.data'),
                'type' => 'GET',
                'dataSrc' => 'data'
            ],
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'inscripcion_nombre', 'name' => 'inscripcion_nombre'],
                ['data' => 'clase_nombre', 'name' => 'clase_nombre'],
                ['data' => 'presente', 'name' => 'presente'],
                ['data' => 'actions', 'name' => 'actions', 'orderable' => false, 'searchable' => false],
            ],
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            ]
        ];

        return view('asistencias.index', compact('heads', 'config'));
    }

    public function data()
    {
        $role = auth()->user()->role;

        switch ($role) {
            case 'admin':
                $query = Asistencia::query();
                break;
            case 'profesor':
                $query = Asistencia::whereHas('inscripcion.cursoGestion.cursoProfesores', function($query) {
                    $query->where('profesor_id', auth()->user()->profesor->id);
                });
                break;
            case 'alumno':
                $query = Asistencia::whereHas('inscripcion', function ($query) {
                    $query->where('alumno_id', auth()->user()->alumno->id);
                });
                break;
            default:
                $query = Asistencia::query();
        }

        return DataTables::of($query)
            ->addColumn('inscripcion_nombre', function ($asistencia) {
                return $asistencia->inscripcion->alumno->nombre . ' - (' . $asistencia->inscripcion->cursoGestion->nombre . ')' ?? '';
            })
            ->addColumn('clase_nombre', function ($asistencia) {
                return 'N° ' . $asistencia->clase->numero_clase . ' - (' . $asistencia->clase->fecha_clase . ')' ?? '';
            })
            ->addColumn('presente', function($asistencia) {
                if ($asistencia->presente) {
                    return '<input type="checkbox" checked disabled />';
                } else {
                    return '<input type="checkbox" disabled />';
                }
            })
            ->addColumn('actions', function ($asistencia) {
                return view('asistencias.partials._actions', compact('asistencia'))->render();
            })
            ->rawColumns(['presente', 'actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get the authenticated user
        $user = auth()->user();

        if ($user->hasRole('profesor') && $user->profesor) {
            // If user is a profesor, get only inscripciones for their assigned cursos
            $inscripciones = Inscripcion::whereHas('cursoGestion.cursoProfesores', function($query) use ($user) {
                $query->where('profesor_id', $user->profesor->id);
            })->get();

            // Get only their assigned clases
            $clases = Clase::whereHas('cursoGestion.cursoProfesores', function($query) use ($user) {
                $query->where('profesor_id', $user->profesor->id);
            })->get();
        } else {
            // For non-profesor users, get all inscripciones and clases
            $inscripciones = Inscripcion::all();
            $clases = Clase::all();
        }

        return view('asistencias.create', compact('inscripciones', 'clases'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AsistenciaRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['presente'] = $request->boolean('presente');

        Asistencia::create($validatedData);

        return redirect()
            ->route('asistencias.index')
            ->with('success', 'Asistencia creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Asistencia $asistencia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asistencia $asistencia)
    {
        // Get the authenticated user
        $user = auth()->user();

        if ($user->hasRole('profesor') && $user->profesor) {
            // If user is a profesor, get only inscripciones for their assigned cursos
            $inscripciones = Inscripcion::whereHas('cursoGestion.cursoProfesores', function($query) use ($user) {
                $query->where('profesor_id', $user->profesor->id);
            })->get();

            // Get only their assigned clases
            $clases = Clase::whereHas('cursoGestion.cursoProfesores', function($query) use ($user) {
                $query->where('profesor_id', $user->profesor->id);
            })->get();
        } else {
            // For non-profesor users, get all inscripciones and clases
            $inscripciones = Inscripcion::all();
            $clases = Clase::all();
        }

        return view('asistencias.edit', compact('asistencia', 'inscripciones', 'clases'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AsistenciaRequest $request, Asistencia $asistencia)
    {
        $validatedData = $request->validated();
        $validatedData['presente'] = $request->boolean('presente');

        $asistencia->update($validatedData);

        return redirect()
            ->route('asistencias.index')
            ->with('success', 'Asistencia actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asistencia $asistencia)
    {
        $asistencia->delete();

        return response()->json([
            'success' => true,
            'title' => 'Eliminar',
            'message' => 'Asistencia eliminada correctamente'
        ]);
    }
}
