<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alimento extends Model
{
     protected $table = 'alimentos';

    protected $fillable = [
        'nombre',
        'categoria',
        'proteinas',
        'carbohidratos',
        'grasas',
        'kcal_por_100g',
    ];
}
