<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class CursoProfesor extends Model implements Auditable
{
    use AuditableTrait;

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
