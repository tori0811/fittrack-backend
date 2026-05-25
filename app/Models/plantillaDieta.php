<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class plantillaDieta extends Model
{
    protected $table = 'plantillas_dieta';

    protected $fillable = [
        'trainer_id',
        'titulo',
        'tipo',
        'tema',
        'descripcion',
        'modo_seguro',
        'alergenos',
        'advertencias',
        'calorias_on',
        'calorias_off',
        'proteinas_on',
        'proteinas_off',
        'carbohidratos_on',
        'carbohidratos_off',
        'grasas_on',
        'grasas_off',
        'actividad_on',
        'actividad_off',
        'pre_entreno',
        'post_entreno',
        'activa',
        'estructura'
    ];

    protected $casts = [
        'alergenos' => 'array',
        'advertencias' => 'array',
        'estructura' => 'array',
        'modo_seguro' => 'boolean',
    ];

}
