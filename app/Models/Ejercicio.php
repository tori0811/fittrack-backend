<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ejercicio extends Model
{
    protected $table = 'ejercicios';

    protected $fillable = [

        'entreno_id',
        'grupo_muscular',
        'nombre',
        'video_url',
        'fatiga',
    ];

    public function entreno()
{
    return $this->belongsTo(Entreno::class, 'entreno_id');
}

    //Series del ejercicio

    public function series() {
        return $this->hasMany(SerieEjercicio::class, 'ejercicio_id');
    }
}
