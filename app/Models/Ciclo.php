<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Ciclo extends Model implements Auditable
{
    use AuditableTrait;

    protected $table = 'ciclos';

    protected $id = 'id';

    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_fin',
        'estado'
    ];

    public function cursosCiclos()
    {
        return $this->hasMany(CursoCiclo::class);
    }
}
