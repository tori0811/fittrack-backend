<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    protected $table = 'journal_entries';

    protected $fillable = [
        'user_id',
        'fecha',
        'estado_animo',
        'energia',
        'suenio_horas',
        'entreno',
        'nota'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
