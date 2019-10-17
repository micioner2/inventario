<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    
    protected $table = 'detalle_ventas';
    protected $guarded = ['id'];
    protected $fillable = [
        'idventa', 
        'idproducto',
        'precio_venta',
        'cantidad',
        'igv',
        'importe'
    ];
    public $timestamps = false;
}
