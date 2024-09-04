<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_cliente', 
        'pago', 
        'forma_pago', 
        'fecha_pedido', 
        'id_evento', 
        'id_entrega', 
        'estado'
    ];

    /**
     * Relación con Cliente.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    /**
     * Relación con Evento.
     */
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento');
    }

    /**
     * Relación con Entrega.
     */
    public function entrega()
    {
        return $this->belongsTo(Entrega::class, 'id_entrega');
    }
}
