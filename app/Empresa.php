<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable = ['razon_social','direccion','telefono','ruta'];
    public $timestamps = false;
}
