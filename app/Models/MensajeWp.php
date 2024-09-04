<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MensajeWp extends Model
{
    use HasFactory;

    protected $table = 'mensajes_wp';

    protected $fillable = [
        'cuerpo',
    ];
}
