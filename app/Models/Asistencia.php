<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $table = 'asistencias';
    
    protected $id = 'id';

    protected $fillable = [
        'inscripcion_id',
        'clase_id',
        'presente',
    ];
}
