<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Microciclo extends Model
{
    protected $fillable = [
        'bloque_id',
        'numero',
        'descarga',
        'completado'
    ];

    public function bloque()
    {
        return $this->belongsTo(Bloque::class);
    }

    public function entrenos()
    {
        return $this->hasMany(Entreno::class);
    }
}
