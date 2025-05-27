<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    protected $table = 'profesores';

    protected $id = 'id';

    protected $fillable = [
        'nombre',
        'especialidad',
        'user_id'
    ];
}
