<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class CursoCiclo extends Model implements Auditable
{
    use AuditableTrait;

    protected $table = 'curso_ciclo';

    protected $id = 'id';

    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_fin',
        'curso_id',
        'ciclo_id',
        'estado'
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class);
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }

    public function cursoProfesores()
    {
        return $this->hasMany(CursoProfesor::class);
    }

}
