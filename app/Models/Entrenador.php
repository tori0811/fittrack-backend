<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrenador extends Model
{
    protected $table = 'entrenadores';

    protected $fillable = [
        'nombre',
        'especialidad',
        'experiencia',
        'descripcion',
        'imagen',
        'user_id',
    ];

    public function user() {
         
        return $this->belongsTo(User::class);
    }

    public function getImagenAttribute($value)
    {
        return $value 
            ? asset('storage/entrenadores/' . $value)
            : asset('storage/entrenadores/default.avif'); 
    }
}
