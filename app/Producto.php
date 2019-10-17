<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = ['idcategoria','codigo','descripcion','unidad_medida','ruta','stock','precio_compra','precio_venta','estado'];
    public $timestamps = false;
    protected $guarded = ['id'];
}
