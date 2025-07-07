<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Alumno extends Model implements Auditable
{
    use AuditableTrait;

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

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }

    public function pagosMatriculas()
    {
        return $this->hasMany(PagoMatricula::class);
    }
}
