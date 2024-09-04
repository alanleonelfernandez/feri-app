<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'evento';

    protected $fillable = [
        'fecha_evento',
        'link_vivo',
    ];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_evento');
    }
}
