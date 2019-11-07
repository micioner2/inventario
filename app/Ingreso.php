<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $fillable = [
        'idpersona', 
        'idusuario',
        'tipo_comprobante',
        'serie_comprobante',
        'numero_comprobante',
        'total',
        'estado'
    ];

    protected $guarded = ['id'];

    public function usuario()
    {
        return $this->belongsTo('App\User');
    }

}


