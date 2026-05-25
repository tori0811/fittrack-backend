<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
     protected $fillable = [
        'user_id',

        //Datos personales
        'apellido',
        'documento',

        //Contacto
        'telefono',

        //Ubicacion
        'pais',
        'provincia',
        'ciudad',
        'codigo_postal',
        'direccion',
        'direccion_secundaria'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
