<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;
use Carbon\Carbon;

class AuditoriaController extends Controller
{
    public function index()
    {
        $audits = Audit::with('user')->latest()->get();

        $tableData = [];
        foreach ($audits as $audit) {
            $username = $audit->user ? $audit->user->username : 'N/A';

            $operation = $this->translateOperation($audit->event);
            $modelType = $this->getModelBaseName($audit->auditable_type);
            $recordId = $audit->auditable_id;
            $dataTime = $audit->created_at->format('d/m/Y H:i:s');

            $oldValues = $audit->old_values ? json_encode($audit->old_values, JSON_PRETTY_PRINT) : 'N/A';
            $newValues = $audit->new_values ? json_encode($audit->new_values, JSON_PRETTY_PRINT) : 'N/A';

            $tableData[] = [
                'user' => $username,
                'operation' => $operation,
                'model_type' => $modelType,
                'record_id' => $recordId,
                'date_time' => $dataTime,
                'old_values' => $oldValues,
                'new_values' => $newValues,
            ];
        }

        $heads = [
            ['label' => 'Usuario', 'width' => 10],
            ['label' => 'Operación', 'width' => 10],
            ['label' => 'Tabla', 'width' => 10],
            ['label' => 'ID Reg.', 'width' => 10],
            ['label' => 'Fecha/Hora', 'width' => 15],
            ['label' => 'Valores Anteriores', 'noexport' => true],
            ['label' => 'Valores Nuevos', 'noexport' => true],
        ];

        $config = [
            'order' => [[4, 'desc']], // Ordenar por fecha/hora descendente
            'columns' => [null, null, null, null, null, ['orderable' => false], ['orderable' => false]],
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            ]
        ];

        return view('auditoria.index', compact('tableData', 'heads', 'config'));
    }

    protected function translateOperation(string $event): string
    {
        switch ($event) {
            case 'created':
                return 'Creación';
            case 'updated':
                return 'Actualización';
            case 'deleted':
                return 'Eliminación';
            default:
                return 'Operación desconocida';
        }
    }

    protected function getModelBaseName(string $auditableType): string
    {
        $baseName = class_basename($auditableType);
        switch ($baseName) {
            case 'User': return 'Usuario';
            case 'Alumno': return 'Alumno';
            case 'Profesor': return 'Profesor';
            case 'Gestion': return 'Gestion';
            case 'Curso': return 'Curso';
            case 'CursoGestion': return 'Curso y Gestion';
            case 'CursoProfesor': return 'Curso y Profesor';
            case 'Inscripcion': return 'Inscripcion';
            case 'Pago': return 'Pago';
            case 'Clase': return 'Clase';
            case 'Asistencia': return 'Asistencia';
            case 'Calificacion': return 'Calificacion';
            default: return $baseName;
        }
    }
}
