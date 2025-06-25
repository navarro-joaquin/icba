<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Profesor extends Model implements Auditable
{
    use AuditableTrait;

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
