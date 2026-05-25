<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserQuestionnaire extends Model
{
    protected $table = 'user_questionnaires';

    protected $fillable = [
        'user_id',
        'objetivo',
        'actividad',
        'peso',
        'altura',
        'dias',
        'experiencia',
        'tuvo_lesion',
        'lesion_pasada',
        'intolerancias',
        'estilo_alimentacion',
        'alimentos_no_gustan',
        'agua',
        'sueno',
        'estres'
    ];

    protected $casts = [
        'intolerancias' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

