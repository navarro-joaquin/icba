<?php

namespace App\Http\Controllers;

use App\Models\CursoGestion;
use App\Models\Curso;
use App\Models\Gestion;
use App\Http\Requests\CursoGestionRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CursoGestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heads = [
            'ID',
            'Nombre',
            'Curso',
            'Gestión',
            'Estado',
            ['label' => 'Acciones', 'no-export' => true, 'searchable' => false, 'orderable' => false]
        ];

        $config = [
            'processing' => true,
            'serverSide' => true,
            'ajax' => [
                'url' => route('cursos-gestiones.data'),
                'type' => 'GET',
                'dataSrc' => 'data'
            ],
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'nombre', 'name' => 'nombre'],
                ['data' => 'nombre_curso', 'name' => 'nombre_curso'],
                ['data' => 'nombre_gestion', 'name' => 'nombre_gestion'],
                ['data' => 'estado', 'name' => 'estado'],
                ['data' => 'actions', 'name' => 'actions', 'orderable' => false, 'searchable' => false]
            ],
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            ]
        ];

        return view('cursos-gestiones.index', compact('heads', 'config'));
    }

    public function data()
    {
        $query = CursoGestion::with('curso', 'gestion')->get();
        return DataTables::of($query)
            ->addColumn('nombre_curso', fn ($curso_gestion) => $curso_gestion->curso->nombre ?? '')
            ->addColumn('nombre_gestion', fn ($curso_gestion) => $curso_gestion->gestion->nombre ?? '')
            ->addColumn('actions', function ($curso_gestion) {
                return view('cursos-gestiones.partials._actions', compact('curso_gestion'))->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gestiones = Gestion::where('estado', 'activo')->get();
        $cursos = Curso::where('estado', 'activo')->get();

        return view('cursos-gestiones.create', compact('gestiones', 'cursos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CursoGestionRequest $request)
    {
        $curso = Curso::find($request->curso_id);
        $gestion = Gestion::find($request->gestion_id);
        $validatedData = $request->validated();

        $validatedData['nombre'] = $curso->nombre . ' - ' . $gestion->nombre;
        
        CursoGestion::create($validatedData);

        return redirect()
            ->route('cursos-gestiones.index')
            ->with('success', "Curso $curso->nombre en la gestión $gestion->nombre fue creado correctamente");
    }

    /**
     * Display the specified resource.
     */
    public function show(CursoGestion $curso_gestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CursoGestion $curso_gestion)
    {
        $gestiones = Gestion::where('estado', 'activo')->get();
        $cursos = Curso::where('estado', 'activo')->get();

        return view('cursos-gestiones.edit', compact('curso_gestion', 'gestiones', 'cursos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CursoGestionRequest $request, CursoGestion $curso_gestion)
    {
        $curso = Curso::find($request->curso_id);
        $gestion = Gestion::find($request->gestion_id);
        $validatedData = $request->validated();

        $validatedData['nombre'] = $curso->nombre . ' - ' . $gestion->nombre;
        $curso_gestion->update($validatedData);

        return redirect()
            ->route('cursos-gestiones.index')
            ->with('success', "Curso $curso->nombre en la gestión $gestion->nombre fue actualizado correctamente");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CursoGestion $curso_gestion)
    {
        if ($curso_gestion->estado == 'activo') {
            $curso_gestion->update(['estado' => 'inactivo']);
            $title = 'Desactivar';
            $message = 'Desactivado correctamente';
        } else {
            $curso_gestion->update(['estado' => 'activo']);
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
