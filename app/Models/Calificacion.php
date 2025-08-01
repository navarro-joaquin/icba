<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Calificacion extends Model implements Auditable
{
    use AuditableTrait;

    protected $table = 'calificaciones';

    protected $id = 'id';

    protected $fillable = [
        'inscripcion_id',
        'examen_1',
        'examen_2',
        'nota_final'
    ];

    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class);
    }
}
