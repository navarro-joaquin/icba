<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Pago extends Model implements Auditable
{
    use AuditableTrait;

    protected $table = 'pagos';

    protected $id = 'id';

    protected $fillable = [
        'alumno_id',
        'inscripcion_id',
        'fecha_pago',
        'monto',
        'forma_pago',
        'descripcion'
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class);
    }
}
