<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    protected $table = 'clases';

    protected $id = 'id';

    protected $fillable = [
        'curso_gestion_id',
        'numero_clase',
        'fecha_clase',
        'tema'
    ];

    public function cursoGestion()
    {
        return $this->belongsTo(CursoGestion::class);
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }
}
