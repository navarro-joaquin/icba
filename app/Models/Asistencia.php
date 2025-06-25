<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Asistencia extends Model implements Auditable
{
    use AuditableTrait;

    protected $table = 'asistencias';

    protected $id = 'id';

    protected $fillable = [
        'inscripcion_id',
        'clase_id',
        'presente',
    ];

    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class);
    }

    public function clase()
    {
        return $this->belongsTo(Clase::class);
    }
}
