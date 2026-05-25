<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SerieEjercicio extends Model
{
    protected $table = 'series_ejercicio';

    protected $fillable = [
        'ejercicio_id',
        'reps_objetivo',
        'rpe_objetivo',
        'peso',
        'reps',
        'rpe',
    ];

    // Ejercicio al que pertenece esta serie
    public function ejercicio()
    {
        return $this->belongsTo(Ejercicio::class, 'ejercicio_id');
    }
}