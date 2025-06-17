<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pago;
use Yajra\DataTables\DataTables;

class ReporteController extends Controller
{
    public function pagosRealizados()
    {
        $heads = [
            'Fecha',
            'Alumno',
            'Monto',
            'Forma de pago',
            'Descripcion'
        ]; //

        $config = [
            'processing' => true,
            'serverSide' => true,
            'ajax' => [
                'url' => route('reportes.pagos-realizados.data'),
                'type' => 'GET',
                'dataSrc' => 'data'
            ],
            'columns' => [
                ['data' => 'fecha_pago', 'name' => 'fecha_pago'],
                ['data' => 'alumno_nombre', 'name' => 'alumno_nombre'],
                ['data' => 'monto', 'name' => 'monto'],
                ['data' => 'forma_pago', 'name' => 'forma_pago'],
                ['data' => 'descripcion', 'name' => 'descripcion']
            ],
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            ]
        ];
        return view('reportes.pagos-realizados', compact('heads', 'config'));
    }

    public function pagosRealizadosData(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $formaPago = $request->input('forma_pago');

        $query = Pago::query(); //

        if (!empty($fechaInicio) && !empty($fechaFin)) {
            // Ajustado para incluir todo el día de fin
            $query->whereBetween('fecha_pago', [$fechaInicio, $fechaFin . ' 23:59:59']);
            if (!empty($formaPago)) {
                $query->where('forma_pago', $formaPago);
            }
        } else {
            // Esto asegura que la tabla esté vacía inicialmente si no hay fechas
            $query->whereRaw('1 = 0');
        }

        return DataTables::of($query)
            ->addColumn('alumno_nombre', fn ($pago) => $pago->alumno->nombre ?? '')
            ->addIndexColumn()
            ->make(true);
    }

    public function pagosrealizadosPDF()
    {

    }

    public function alumnosConDeuda()
    {
        return view('reportes.alumnos-con-deuda');
    }

    public function alumnosConDeudaData()
    {

    }

    public function alumnosConDeudaPDF()
    {

    }

    public function planillas()
    {
        return view('reportes.planillas');
    }

    public function planillasData()
    {

    }

    public function planillasPDF()
    {

    }
}
