<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'alumnos';

    protected $id = 'id';

    protected $fillable = [
        'nombre',
        'fecha_nacimiento',
        'user_id',
    ];
}
