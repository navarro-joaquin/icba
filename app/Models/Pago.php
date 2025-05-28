<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';

    protected $id = 'id';

    protected $fillable = [
        'alumno_id',
        'inscripcion_id',
        'fecha_pago',
        'monto',
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
