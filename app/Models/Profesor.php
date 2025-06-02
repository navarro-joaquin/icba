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
        'estado',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cursoProfesores()
    {
        return $this->hasMany(CursoProfesor::class);
    }
}
