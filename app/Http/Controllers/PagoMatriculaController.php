<?php

namespace App\Http\Controllers;

use App\Models\PagoMatricula;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PagoMatriculaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function data()
    {
        $query = PagoMatricula::query();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PagoMatricula $pagoMatricula)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PagoMatricula $pagoMatricula)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PagoMatricula $pagoMatricula)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PagoMatricula $pagoMatricula)
    {
        //
    }
}
