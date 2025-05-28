<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gestion extends Model
{
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
