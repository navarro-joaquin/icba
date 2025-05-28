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

    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class);
    }

    public function clase()
    {
        return $this->belongsTo(Clase::class);
    }
}
