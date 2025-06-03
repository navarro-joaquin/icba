<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Http\Requests\CursoRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heads = [
            'ID',
            'Nombre',
            'Descripción',
            'Estado',
            ['label' => 'Acciones', 'no-export' => true, 'searchable' => false, 'orderable' => false],
        ];

        $config = [
            'processing' => true,
            'serverSide' => true,
            'ajax' => [
                'url' => route('cursos.data'),
                'type' => 'GET',
                'dataSrc' => 'data'
            ],
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'nombre', 'name' => 'nombre'],
                ['data' => 'descripcion', 'name' => 'descripcion'],
                ['data' => 'estado', 'name' => 'estado'],
                ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false]
            ],
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            ]
        ];

        return view('cursos.index', compact('heads', 'config'));
    }

    public function data()
    {
        $query = Curso::query();
        return DataTables::of($query)
            ->addColumn('estado', function($curso) {
                if ($curso->estado == 'activo') {
                    return '<span class="badge badge-success">Activo</span>';
                } else {
                    return '<span class="badge badge-secondary">Inactivo</span>';
                }
            })
            ->addColumn('actions', function($curso) {
                return view('cursos.partials._actions', compact('curso'))->render();
            })
            ->rawColumns(['estado', 'actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cursos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CursoRequest $request)
    {
        Curso::create($request->validated());

        return redirect()
            ->route('cursos.index')
            ->with('success', 'Curso creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Curso $curso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curso $curso)
    {
        return view('cursos.edit', compact('curso'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CursoRequest $request, Curso $curso)
    {
        $curso->update($request->validated());

        return redirect()
            ->route('cursos.index')
            ->with('success', 'Curso actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curso $curso)
    {
        if ($curso->estado == 'activo') {
            $curso->update(['estado' => 'inactivo']);
            $title = 'Desactivar';
            $message = 'El curso ha sido desactivado correctamente';
        } else {
            $curso->update(['estado' => 'activo']);
            $title = 'Activar';
            $message = 'El curso ha sido activado correctamente';
        }

        return response()->json([
            'success' => true,
            'title' => $title,
            'message' => $message
        ]);
    }
}
