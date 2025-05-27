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
}
