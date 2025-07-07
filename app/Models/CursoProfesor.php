<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class CursoProfesor extends Model implements Auditable
{
    use AuditableTrait;

    protected $table = 'curso_profesor';

    protected $id = 'id';

    protected $fillable = [
        'nombre',
        'estado',
        'fecha_inicio',
        'fecha_fin',
        'curso_ciclo_id',
        'profesor_id'
    ];

    public function cursoCiclo()
    {
        return $this->belongsTo(CursoCiclo::class);
    }

    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }
}
