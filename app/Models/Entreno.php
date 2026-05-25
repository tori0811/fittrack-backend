<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entreno extends Model
{
    protected $fillable = [
        'microciclo_id',
        'titulo',
        'dia_semana',
        'orden',
        'completado'
    ];

    public function microciclo()
    {
        return $this->belongsTo(Microciclo::class, 'microciclo_id');
    }

    public function ejercicios()
    {
        return $this->hasMany(Ejercicio::class, 'entreno_id');
    }
}
