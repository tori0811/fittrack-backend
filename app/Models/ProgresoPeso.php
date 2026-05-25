<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgresoPeso extends Model
{
    protected $table = 'progreso_pesos';

    protected $fillable = [
        'user_id',
        'fecha',
        'peso'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

