<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Inscripcion extends Model implements Auditable
{
    use AuditableTrait;

    protected $table = 'inscripciones';

    protected $primaryKey = 'id';

    protected $fillable = [
        'alumno_id',
        'curso_gestion_id',
        'fecha_inscripcion',
        'monto_total',
        'estado'
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function cursoGestion()
    {
        return $this->belongsTo(CursoGestion::class);
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class);
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
