<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class PagoMatricula extends Model implements Auditable
{
    use AuditableTrait;

    protected $table = 'pagos_matriculas';

    protected $fillable = [
        'alumno_id',
        'matricula_id',
        'monto',
        'fecha_pago',
        'forma_pago',
        'descripcion'
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function matricula()
    {
        return $this->belongsTo(Matricula::class);
    }
}
