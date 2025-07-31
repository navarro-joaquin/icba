<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Inscripcion;
use App\Http\Requests\CalificacionRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class CalificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heads = [
            'ID',
            'Inscripción',
            'Examen 1',
            'Examen 2',
            'Nota Final',
            ['label' => 'Acciones', 'no-export' => true, 'searchable' => false, 'orderable' => false]
        ];

        $config = [
            'processing' => true,
            'serverSide' => true,
            'ajax' => [
                'url' => route('calificaciones.data'),
                'type' => 'GET',
                'dataSrc' => 'data'
            ],
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'inscripcion_nombre', 'name' => 'inscripcion_nombre'],
                ['data' => 'examen_1', 'name' => 'examen_1'],
                ['data' => 'examen_2', 'name' => 'examen_2'],
                ['data' => 'nota_final', 'name' => 'nota_final'],
                ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false]
            ],
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            ]
        ];

        return view('calificaciones.index', compact('heads', 'config'));
    }

    public function data()
    {
        $role = Auth()->user()->role;

        switch ($role) {
            case 'admin':
                $query = Calificacion::with('inscripcion');
                break;
            case 'profesor':
                $query = Calificacion::with('inscripcion')->whereHas('inscripcion.cursoCiclo.cursoProfesores', function ($query) {
                    $query->where('profesor_id', Auth()->user()->profesor->id);
                });
                break;
            case 'alumno':
                // Si el alumno no tiene pagos completos en la inscripción, no mostrar la calificación
                $query = Calificacion::with(['inscripcion', 'inscripcion.pagos'])
                    ->whereHas('inscripcion', function ($query) {
                        $query->where('alumno_id', Auth()->user()->alumno->id)
                            ->whereExists(function($subquery) {
                                $subquery->select(DB::raw(1))
                                    ->from('pagos')
                                    ->whereColumn('pagos.inscripcion_id', 'inscripciones.id')
                                    ->groupBy('pagos.inscripcion_id')
                                    ->havingRaw('SUM(pagos.monto) >= inscripciones.monto_total');
                            });
                    });
                break;
            default:
                $query = Calificacion::with('inscripcion');
        }

        return DataTables::of($query)
            ->addColumn('inscripcion_nombre', function ($calificacion) {
                return $calificacion->inscripcion->alumno->nombre . ' - (' . $calificacion->inscripcion->cursoCiclo->nombre . ')' ?? '';
            })
            ->addColumn('actions', function ($calificacion) {
                return view('calificaciones.partials._actions', compact('calificacion'))->render();
            })
            ->rawColumns(['actions'])
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
            $inscripciones = Inscripcion::where('estado', 'activo')
                ->whereHas('cursoCiclo.cursoProfesores', function($query) use ($user) {
                    $query->where('profesor_id', $user->profesor->id);
                })
                ->get();
        } else {
            // For non-profesor users, get all active inscripciones
            $inscripciones = Inscripcion::where('estado', 'activo')->get();
        }

        return view('calificaciones.create', compact('inscripciones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CalificacionRequest $request)
    {
        Calificacion::create($request->validated());

        return redirect()
            ->route('calificaciones.index')
            ->with('success', 'Calificación creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Calificacion $calificacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Calificacion $calificacion)
    {
        // Get the authenticated user
        $user = auth()->user();

        if ($user->hasRole('profesor') && $user->profesor) {
            // If user is a profesor, get only inscripciones for their assigned cursos
            $inscripciones = Inscripcion::where('estado', 'activo')
                ->whereHas('cursoCiclo.cursoProfesores', function($query) use ($user) {
                    $query->where('profesor_id', $user->profesor->id);
                })
                ->get();
        } else {
            // For non-profesor users, get all active inscripciones
            $inscripciones = Inscripcion::where('estado', 'activo')->get();
        }

        return view('calificaciones.edit', compact('calificacion', 'inscripciones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CalificacionRequest $request, Calificacion $calificacion)
    {
        $calificacion->update($request->validated());

        return redirect()
            ->route('calificaciones.index')
            ->with('success', 'Calificación actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Calificacion $calificacion)
    {
        $calificacion->delete();

        return response()->json([
            'success' => true,
            'title' => 'Eliminado',
            'message' => 'Calificación eliminada correctamente'
        ]);
    }
}
