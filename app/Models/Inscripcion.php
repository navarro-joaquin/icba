<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    protected $table = 'inscripciones';

    protected $primaryKey = 'id';

    protected $fillable = [
        'alumno_id',
        'curso_gestion_id',
        'fecha_inscripcion',
        'monto_total'
    ];
}
