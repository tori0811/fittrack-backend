<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantillaEntrenamiento extends Model
{
    protected $table = 'plantillas_entrenamiento';

    protected $fillable = [
        'trainer_id',
        'name',
        'type',
        'description',
        'estructura',
        'gender',
        'routineType',
        'level',
        'theme',
    ];

    protected $casts = [
        'estructura' => 'array',
    ];
}

