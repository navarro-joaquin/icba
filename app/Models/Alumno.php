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
        'estado',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsto(User::class);
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
