<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntrenadorReview extends Model
{
    use HasFactory;

    protected $table = 'entrenador_reviews';

    protected $fillable = [
        'user_id',      
        'trainer_id',   
        'rating',       // 1 a 5
        'comentario'
    ];

    /* 
       RELACIONES
    */

    // Cliente que deja la reseña
    public function cliente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Entrenador reseñado
    public function entrenador()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }
}
