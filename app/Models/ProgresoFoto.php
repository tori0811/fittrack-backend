<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgresoFoto extends Model
{
    protected $table = 'progreso_fotos';

    protected $fillable = [
        'user_id',
        'ruta_foto',
        'fecha'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
