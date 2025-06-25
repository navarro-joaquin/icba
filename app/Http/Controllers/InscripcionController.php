<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\CursoGestion;
use App\Models\Alumno;
use App\Http\Requests\InscripcionRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class InscripcionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heads = [
            'ID',
            'Alumno',
            'Curso-Gestión',
            'Fecha de inscripción',
            'Monto total (Bs.)',
            'Estado',
            ['label' => 'Acciones', 'no-export' => true, 'orderable' => false, 'searchable' => false],
        ];

        $config = [
            'processing' => true,
            'serverSide' => true,
            'ajax' => [
                'url' => route('inscripciones.data'),
                'type' => 'GET',
                'dataSrc' => 'data'
            ],
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'alumno_nombre', 'name' => 'alumno_nombre'],
                ['data' => 'curso_gestion_nombre', 'name' => 'curso_gestion_nombre'],
                ['data' => 'fecha_inscripcion', 'name' => 'fecha_inscripcion'],
                ['data' => 'monto_total', 'name' => 'monto_total'],
                ['data' => 'estado', 'name' => 'estado'],
                ['data' => 'actions', 'name' => 'actions', 'orderable' => false, 'searchable' => false],
            ],
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            ]
        ];

        return view('inscripciones.index', compact('heads', 'config'));
    }

    public function data()
    {
        $query = Inscripcion::with('alumno', 'cursoGestion')->get();

        return DataTables::of($query)
            ->addColumn('alumno_nombre', fn ($inscripcion) => $inscripcion->alumno->nombre ?? '')
            ->addColumn('curso_gestion_nombre', fn ($inscripcion) => $inscripcion->cursoGestion->nombre ?? '')
            ->addColumn('estado', function ($inscripcion) {
                if ($inscripcion->estado == 'activo') {
                    return '<span class="badge badge-success">Activo</span>';
                } else {
                    return '<span class="badge badge-secondary">Inactivo</span>';
                }
            })
            ->addColumn('actions', function ($inscripcion) {
                return view('inscripciones.partials._actions', compact('inscripcion'))->render();
            })
            ->rawColumns(['estado', 'actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cursosGestiones = CursoGestion::where('estado', 'activo')->get();
        $alumnos = Alumno::where('estado', 'activo')->get();

        return view('inscripciones.create', compact('cursosGestiones', 'alumnos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InscripcionRequest $request)
    {
        Inscripcion::create($request->validated());

        return redirect()
            ->route('inscripciones.index')
            ->with('success', 'Inscripción creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inscripcion $inscripcion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inscripcion $inscripcion)
    {
        $cursosGestiones = CursoGestion::where('estado', 'activo')->get();
        $alumnos = Alumno::where('estado', 'activo')->get();

        return view('inscripciones.edit', compact('inscripcion', 'cursosGestiones', 'alumnos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InscripcionRequest $request, Inscripcion $inscripcion)
    {
        $inscripcion->update($request->validated());

        return redirect()
            ->route('inscripciones.index')
            ->with('success', 'Inscripción actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inscripcion $inscripcion)
    {
        if ($inscripcion->estado == 'activo') {
            $inscripcion->update(['estado' => 'inactivo']);
            $title = 'Desactivar';
            $message = 'Inscripción desactivada correctamente';
        } else {
            $inscripcion->update(['estado' => 'activo']);
            $title = 'Activar';
            $message = 'Inscripción activada correctamente';
        }

        return response()->json([
            'success' => true,
            'title' => $title,
            'message' => $message
        ]);
    }
}
