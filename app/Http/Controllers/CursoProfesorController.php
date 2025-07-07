<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use App\Models\CursoCiclo;
use App\Models\CursoProfesor;
use App\Http\Requests\CursoProfesorRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CursoProfesorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heads = [
            'ID',
            'Nombre',
            'Curso-Ciclo',
            'Profesor',
            'Estado',
            ['label' => 'Acciones', 'no-export' => true, 'searchable' => false, 'orderable' => false]
        ];

        $config = [
            'processing' => true,
            'serverSide' => true,
            'ajax' => [
                'url' => route('cursos-profesores.data'),
                'type' => 'GET',
                'dataSrc' => 'data'
            ],
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'nombre', 'name' => 'nombre'],
                ['data' => 'curso_ciclo_nombre', 'name' => 'curso_ciclo_nombre'],
                ['data' => 'profesor_nombre', 'name' => 'profesor_nombre'],
                ['data' => 'estado', 'name' => 'estado'],
                ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false],
            ],
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            ]
        ];

        return view('cursos-profesores.index', compact('heads', 'config'));
    }

    public function data()
    {
        $query = CursoProfesor::query();

        return DataTables::of($query)
            ->addColumn('curso_ciclo_nombre', fn ($curso_profesor) => $curso_profesor->cursoCiclo->nombre ?? '')
            ->addColumn('profesor_nombre', fn ($curso_profesor) => $curso_profesor->profesor->nombre ?? '')
            ->addColumn('estado', function ($curso_profesor) {
                return match ($curso_profesor->estado) {
                    'activo' => '<span class="badge bg-success">Activo</span>',
                    'inactivo' => '<span class="badge bg-secondary">Inactivo</span>',
                    default => '<span class="badge bg-danger">Cancelada</span>',
                };
            })
            ->addColumn('actions', function ($curso_profesor) {
                return view('cursos-profesores.partials._actions', compact('curso_profesor'))->render();
            })
            ->rawColumns(['estado', 'actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cursosCiclos = CursoCiclo::where('estado', 'activo')->get();
        $profesores = Profesor::where('estado', 'activo')->get();

        return view('cursos-profesores.create', compact('cursosCiclos', 'profesores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CursoProfesorRequest $request)
    {
        $cursoCiclo = CursoCiclo::find($request->curso_ciclo_id);
        $profesor = Profesor::find($request->profesor_id);
        $nombre = $cursoCiclo->nombre . ' - ' . $profesor->nombre;

        $validatedData = $request->validated();
        $validatedData['nombre'] = $nombre;

        CursoProfesor::create($validatedData);

        return redirect()
            ->route('cursos-profesores.index')
            ->with('success', "Curso $cursoCiclo->nombre asignado al profesor $profesor->nombre correctamente");
    }

    /**
     * Display the specified resource.
     */
    public function show(CursoProfesor $curso_profesor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CursoProfesor $curso_profesor)
    {
        $cursosCiclos = CursoCiclo::where('estado', 'activo')->get();
        $profesores = Profesor::where('estado', 'activo')->get();

        return view('cursos-profesores.edit', compact('curso_profesor', 'cursosCiclos', 'profesores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CursoProfesor $curso_profesor)
    {
        $cursoCiclo = CursoCiclo::find($request->curso_ciclo_id);
        $profesor = Profesor::find($request->profesor_id);
        $nombre = $cursoCiclo->nombre . ' - ' . $profesor->nombre;

        $validatedData = $request->validated();
        $validatedData['nombre'] = $nombre;

        $curso_profesor->update($validatedData);

        return redirect()
            ->route('cursos-profesores.index')
            ->with('success', "Curso $cursoCiclo->nombre asignado al profesor $profesor->nombre correctamente");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CursoProfesor $curso_profesor)
    {
        if ($curso_profesor->estado == 'activo') {
            $curso_profesor->update(['estado' => 'inactivo']);
            $title = 'Desactivar';
            $message = 'Registro desactivado correctamente';
        } else {
            $curso_profesor->update(['estado' => 'activo']);
            $title = 'Activar';
            $message = 'Registro activado correctamente';
        }

        return response()->json([
            'success' => true,
            'title' => $title,
            'message' => $message
        ]);
    }
}
