@extends('layouts.pdf')

@section('titulo', 'Alumnos con Deuda')
@section('contenido')

    <div class="row">
        <div class="col-10 justify-content-center align-content-center">
            <h2 class="text-center">Alumnos con Deuda</h2>
        </div>
        <div class="col-2">
            <img src="{{ asset('assets/img/icba.png') }}" alt="logo" class="img-fluid">
        </div>
    </div>
    <div class="row">
        <p><strong>Fecha:</strong> {{ date('d/m/Y') }}</p>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Alumno</th>
                        <th>Curso</th>
                        <th>Deuda (Bs.)</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resultados as $resultado)
                        <tr>
                            <td>{{ $resultado['alumno_nombre'] }}</td>
                            <td>{{ $resultado['inscripcion'] }}</td>
                            <td>{{ $resultado['monto'] }}</td>
                            <td>{{ $resultado['descripcion'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

