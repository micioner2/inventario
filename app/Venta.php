<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $guarded = ['id'];
    protected $fillable = [
        'idcliente', 
        'idusuario',
        'tipo_comprobante',
        'serie_comprobante',
        'numero_comprobante',
        'credito_fiscal',
        'total',
        'estado'
    ];

    public function usuario()
    {
        return $this->belongsTo('App\User');
    }
    public function persona()
    {
        return $this->belongsTo('App\Persona');
    }
}
