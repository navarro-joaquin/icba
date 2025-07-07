<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Matricula extends Model implements Auditable
{
    use AuditableTrait;

    protected $table = 'matriculas';

    protected $fillable = [
        'alumno_id',
        'anio',
        'monto_total',
        'estado'
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function pagosMatriculas()
    {
        return $this->hasMany(PagoMatricula::class);
    }
}
