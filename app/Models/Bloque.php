<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bloque extends Model
{
    protected $fillable = [
        'user_id',
        'trainer_id',
        'plantilla_entrenamiento_id',
        'titulo',
        'descripcion',
        'completado'
    ];

    public function cliente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function entrenador()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function microciclos()
    {
        return $this->hasMany(Microciclo::class);
    }
}
