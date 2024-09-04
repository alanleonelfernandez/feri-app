<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku', 
        'descripcion', 
        'id_categoria', 
        'marca', 
        'stock', 
        'costo', 
        'precio_ml', 
        'precio_venta', 
        'porcentaje_ganancia', 
        'link_imagen', 
        'estado'
    ];

    /**
     * Relación con Categoría.
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }
}
