<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Gestion extends Model implements Auditable
{
    use AuditableTrait;

    protected $table = 'gestiones';

    protected $id = 'id';

    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_fin',
        'estado'
    ];

    public function cursoGestiones()
    {
        return $this->hasMany(CursoGestion::class);
    }
}
