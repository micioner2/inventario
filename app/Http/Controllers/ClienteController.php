<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;

class ClienteController extends Controller
{
    public function index(Request $request){
        $filtro = $request->filtro;
        $cliente = Persona::orderBy('id','asc')->get();
        return compact('cliente');
    }


    public function store(Request $request)
    {
        $cliente = new Persona();
        $cliente->tipo_documento= $request->tipo_documento;
        $cliente->num_documento = $request->num_documento;
        $cliente->nombre = $request->nombre;
        $cliente->razon_social = $request->razon_social;
        $cliente->direccion = $request->direccion;
        $cliente->telefono = $request->telefono;
        $cliente->correo = $request->correo;
        $cliente->save();
    }

    public function edit(Request $request)
    {
        $cliente = Persona::findOrFail($request->id);
        $cliente->nombre = $request->nombre;
        $cliente->razon_social = $request->razon_social;
        $cliente->direccion = $request->direccion;
        $cliente->telefono = $request->telefono;
        $cliente->correo = $request->correo;
        $cliente->save();
    }


    public function update(Request $request){
        if(!$request->ajax())return redirect('/');
        $estado = $request->estado;
        if($estado){
            $cliente = Persona::findOrFail($request->id);
            $cliente->estado = '0';
            $cliente->save();
        }else{
            $cliente =  Persona::findOrFail($request->id);
            $cliente->estado = '1';
            $cliente->save();
        }
    }

    public function listarCbo(Request $request){
        $cliente = Persona::select('id','tipo_documento','num_documento','nombre','razon_social')
        ->where('estado','=','1')->get();
        return compact('cliente');
    }

   
    public function consultaApiSunat(Request $request)
    {
        $num_documento = $request->num_documento;
        $tipo_documento = $request->tipo_documento;
        $nombre = "";
        if ($tipo_documento == "DNI") {
            $nombre = json_encode(file_get_contents("http://aplicaciones007.jne.gob.pe/srop_publico/Consulta/Afiliado/GetNombresCiudadano?DNI=".$num_documento),true);
            
        }else{
            $nombre = json_decode(file_get_contents("https://api.sunat.cloud/ruc/".$num_documento),true);
        }
        return str_replace('|', ' ', $nombre);
    }

}
