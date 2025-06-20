<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Clase extends Model implements Auditable
{
    use AuditableTrait;

    protected $table = 'clases';

    protected $id = 'id';

    protected $fillable = [
        'curso_gestion_id',
        'numero_clase',
        'fecha_clase',
        'tema'
    ];

    public function cursoGestion()
    {
        return $this->belongsTo(CursoGestion::class);
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }
}
