<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'cursos';

    protected $id = 'id';

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado'
    ];

    public function cursoGestiones()
    {
        return $this->hasMany(CursoGestion::class);
    }
}
