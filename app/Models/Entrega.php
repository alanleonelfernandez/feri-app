<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    use HasFactory;

    protected $table = 'entregas';

    protected $fillable = [
        'punto_entrega',
    ];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_entrega');
    }
}
