<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dieta extends Model
{
    protected $table = 'dietas';

    protected $fillable = [
        'user_id',
        'trainer_id',
        'plantillas_dieta_id',
        'titulo',
        'calorias_on',
        'calorias_off',
        'proteinas_on',
        'carbohidratos_on',
        'grasas_on',
        'proteinas_off',
        'carbohidratos_off',
        'grasas_off',
        'actividad_on',
        'actividad_off',
        'pre_entreno',
        'intra_entreno',
        'activa'
    ];

    // Cliente dueño de la dieta
    public function cliente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Entrenador que la asignó
    public function entrenador()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    // Comidas de la dieta
    public function comidas()
    {
        return $this->hasMany(Comida::class, 'dieta_id');
    }
}
