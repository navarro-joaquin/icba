<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heads = [
            'ID',
            'Nombre de usuario',
            'Correo electrónico',
            'Rol',
            'Estado',
            ['label' => 'Acciones', 'no-export' => true, 'orderable' => false, 'searchable' => false],
        ];

        $config = [
            'processing' => true,
            'serverSide' => true,
            'ajax' => [
                'url' => route('usuarios.data'),
                'type' => 'GET',
                'dataSrc' => 'data'
            ],
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'username', 'name' => 'username'],
                ['data' => 'email', 'name' => 'email'],
                ['data' => 'role', 'name' => 'role'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false],
            ],
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            ]
        ];

        return view('usuarios.index', compact('heads', 'config'));
    }

    public function data()
    {
        $query = User::query();
        return DataTables::of($query)
            ->addColumn('status', function($user) {
                $statusValue = $user->status;
                $badgeClass = '';
                $displayText = '';

                if ($statusValue === 'active') {
                    $badgeClass = 'badge-success';
                    $displayText = 'Activo';
                } elseif ($statusValue === 'inactive') {
                    $badgeClass = 'badge-secondary';
                    $displayText = 'Inactivo';
                }

                return "<span class=\"badge {$badgeClass}\">{$displayText}</span>";
            })
            ->addColumn('actions', function($user) {
                return view('usuarios.partials._actions', compact('user'))->render();
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        // $validated = $request->validate([
        //     'username' => 'required|string|max:255',
        //     'email' =>'required|email|max:255|unique:users,email',
        //     'role' => 'required|string|max:255',
        //     'password' => 'required|string|min:8'
        // ]);

        // $validated['password'] = Hash::make($validated['password']);

        User::create($request->validated());

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $usuario)
    {
        $validated = $request->validate([
            'username' =>'required|string|max:255',
            'email' =>'required|email|max:255|unique:users,email,'.$usuario->id,
            'role' =>'required|string|max:255',
            'password' =>'nullable|string|min:8'
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $usuario->update($validated);

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $usuario)
    {
        if ($usuario->status == 'active') {
            $usuario->update(['status' => 'inactive']);
            $valor = 'desactivado';
            $title = 'Desactivar';
        } else {
            $usuario->update(['status' => 'active']);
            $valor = 'activado';
            $title = 'Activar';
        }

        return response()->json([
            'success' => true,
            'title' => $title,
            'message' => "Usuario {$valor} correctamente"
        ]);
    }
}
