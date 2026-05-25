<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comida extends Model
{
    protected $table = 'comidas';

    protected $fillable = [
        'dieta_id',
        'tipo',
        'dia',
        'hora'
    ];

    public function dieta()
    {
        return $this->belongsTo(Dieta::class, 'dieta_id');
    }

    // Opciones de esta comida
    public function opciones()
    {
        return $this->hasMany(OpcionComida::class, 'comida_id');
    }
}
