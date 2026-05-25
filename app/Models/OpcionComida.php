<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpcionComida extends Model
{
    protected $table = 'opciones_comida';

    protected $fillable = [
        'comida_id',
        'titulo_opcion',
        'alimentos'
    ];

    protected $casts = [
        'alimentos' => 'array'
    ];

    public function comida()
    {
        return $this->belongsTo(Comida::class, 'comida_id');
    }
}
