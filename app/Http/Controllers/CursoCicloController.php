<?php

namespace App\Http\Controllers;

use App\Models\CursoCiclo;
use App\Models\Curso;
use App\Models\Ciclo;
use App\Http\Requests\CursoCicloRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class CursoCicloController extends Controller
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
            'Curso',
            'Ciclo',
            'Estado',
            ['label' => 'Acciones', 'no-export' => true, 'searchable' => false, 'orderable' => false]
        ];

        $config = [
            'processing' => true,
            'serverSide' => true,
            'ajax' => [
                'url' => route('cursos-ciclos.data'),
                'type' => 'GET',
                'dataSrc' => 'data'
            ],
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'nombre', 'name' => 'nombre'],
                ['data' => 'fecha_inicio', 'name' => 'fecha_inicio'],
                ['data' => 'fecha_fin', 'name' => 'fecha_fin'],
                ['data' => 'nombre_curso', 'name' => 'nombre_curso'],
                ['data' => 'nombre_ciclo', 'name' => 'nombre_ciclo'],
                ['data' => 'estado', 'name' => 'estado'],
                ['data' => 'actions', 'name' => 'actions', 'orderable' => false, 'searchable' => false]
            ],
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            ]
        ];

        return view('cursos-ciclos.index', compact('heads', 'config'));
    }

    public function data()
    {
        $query = CursoCiclo::query();

        return DataTables::of($query)
            ->addColumn('nombre_curso', fn ($curso_ciclo) => $curso_ciclo->curso->nombre ?? '')
            ->addColumn('fecha_inicio', fn ($curso_ciclo) => Carbon::parse($curso_ciclo->fecha_inicio)->format('d/m/Y'))
            ->addColumn('fecha_fin', fn ($curso_ciclo) => Carbon::parse($curso_ciclo->fecha_fin)->format('d/m/Y'))
            ->addColumn('nombre_ciclo', fn ($curso_ciclo) => $curso_ciclo->ciclo->nombre ?? '')
            ->addColumn('estado', function ($curso_ciclo) {
                return match ($curso_ciclo->estado) {
                    'activo' => '<span class="badge bg-success">Activo</span>',
                    'inactivo' => '<span class="badge bg-secondary">Inactivo</span>',
                    default => '<span class="badge bg-danger">Cancelada</span>',
                };
            })
            ->addColumn('actions', function ($curso_ciclo) {
                return view('cursos-ciclos.partials._actions', compact('curso_ciclo'))->render();
            })
            ->rawColumns(['estado', 'actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ciclos = Ciclo::where('estado', 'activo')->get();
        $cursos = Curso::where('estado', 'activo')->get();

        return view('cursos-ciclos.create', compact('ciclos', 'cursos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CursoCicloRequest $request)
    {
        $curso = Curso::find($request->curso_id);
        $ciclo = Ciclo::find($request->ciclo_id);
        $validatedData = $request->validated();

        $validatedData['nombre'] = $curso->nombre . ' - ' . $ciclo->nombre;

        CursoCiclo::create($validatedData);

        return redirect()
            ->route('cursos-ciclos.index')
            ->with('success', "Curso $curso->nombre en el ciclo $ciclo->nombre fue creado correctamente");
    }

    /**
     * Display the specified resource.
     */
    public function show(CursoCiclo $curso_ciclo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CursoCiclo $curso_ciclo)
    {
        $ciclos = Ciclo::where('estado', 'activo')->get();
        $cursos = Curso::where('estado', 'activo')->get();

        return view('cursos-ciclos.edit', compact('curso_ciclo', 'ciclos', 'cursos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CursoCicloRequest $request, CursoCiclo $curso_ciclo)
    {
        $curso = Curso::find($request->curso_id);
        $ciclo = Ciclo::find($request->ciclo_id);
        $validatedData = $request->validated();

        $validatedData['nombre'] = $curso->nombre . ' - ' . $ciclo->nombre;
        $curso_ciclo->update($validatedData);

        return redirect()
            ->route('cursos-ciclos.index')
            ->with('success', "Curso $curso->nombre en el ciclo $ciclo->nombre fue actualizado correctamente");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CursoCiclo $curso_ciclo)
    {
        if ($curso_ciclo->estado == 'activo') {
            $curso_ciclo->update(['estado' => 'inactivo']);
            $title = 'Desactivar';
            $message = 'Desactivado correctamente';
        } else {
            $curso_ciclo->update(['estado' => 'activo']);
            $title = 'Activar';
            $message = 'Activado correctamente';
        }

        return response()->json([
            'success' => true,
            'title' => $title,
            'message' => $message
        ]);
    }
}
