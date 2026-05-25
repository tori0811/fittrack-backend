<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgresoMedidas extends Model
{
    protected $table = 'progreso_medidas';

    protected $fillable = [
        'user_id',
        'fecha',
        'pecho',
        'espalda',
        'cintura',
        'cadera',
        'brazo',
        'pierna',
        'gemelo'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
