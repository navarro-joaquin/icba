<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    protected $table = 'calificaciones';

    protected $id = 'id';

    protected $fillable = [
        'inscripcion_id',
        'nota',
        'fecha_registro',
    ];
}
