<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = ['tipo_persona','tipo_documento','num_documento','nombre','razon_social','direccion','telefono','correo'];
    public $timestamps = false;
    protected $guarded = ['id'];


    public function user()
    {
        return $this->hasOne('App\User');
    }

}
