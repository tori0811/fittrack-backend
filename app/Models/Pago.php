<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';

    protected $fillable = [
        'user_id',       
        'trainer_id',   
        'cantidad',
        'descripcion',
        'fecha',
    ];

    /* 
       RELACIONES
    */

    // Cliente
    public function cliente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Entrenador
    public function entrenador()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }
}
