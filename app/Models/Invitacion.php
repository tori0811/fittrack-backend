<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitacion extends Model
{
    protected $table = 'invitaciones';
    
    protected $fillable = [
        'entrenador_id',
        'email',
        'token',
        'usado',
    ];

    public function entrenador()
    {
        return $this->belongsTo(User::class, 'entrenador_id');
    }
}