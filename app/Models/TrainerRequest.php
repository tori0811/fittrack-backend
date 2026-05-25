<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainerRequest extends Model
{
    protected $table = 'trainer_requests';

    protected $fillable = [
        'trainer_id',
        'user_id',
        'aceptada'
    ];

    public function entrenador()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function cliente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
