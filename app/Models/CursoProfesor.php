<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CursoProfesor extends Model
{
    protected $table = 'curso_profesor';

    protected $id = 'id';

    protected $fillable = [
        'nombre',
        'estado',
        'curso_gestion_id',
        'profesor_id'
    ];

    public function cursoGestion()
    {
        return $this->belongsTo(CursoGestion::class);
    }

    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }
}
