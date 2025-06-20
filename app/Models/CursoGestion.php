<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class CursoGestion extends Model implements Auditable
{
    use AuditableTrait;

    protected $table = 'curso_gestion';

    protected $id = 'id';

    protected $fillable = [
        'nombre',
        'curso_id',
        'gestion_id',
        'estado'
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function gestion()
    {
        return $this->belongsTo(Gestion::class);
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }

    public function cursoProfesores()
    {
        return $this->hasMany(CursoProfesor::class);
    }

    public function clases()
    {
        return $this->hasMany(Clase::class);
    }
}
