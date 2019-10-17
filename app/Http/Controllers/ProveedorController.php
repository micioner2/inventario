<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedor;
use App\Persona;

class ProveedorController extends Controller
{

    public function index(Request $request){
        if(!$request->ajax())return redirect('/');
        $filtro = $request->filtro;
        $proveedor = Proveedor::join('personas as p','p.id','=','proveedores.id')
        ->orderBy('proveedores.id','asc')->get();
        return compact('proveedor');
    }

    public function store(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $cliente = new Persona();
        $cliente->tipo_documento= $request->tipo_documento;
        $cliente->num_documento = $request->num_documento;
        $cliente->nombre = $request->nombre;
        $cliente->razon_social = $request->razon_social;
        $cliente->direccion = $request->direccion;
        $cliente->telefono = $request->telefono;
        $cliente->correo = $request->correo;
        $cliente->save();

        $proveedor = new Proveedor();
        $proveedor->id = $cliente->id;
        $proveedor->save();
    }


    public function edit(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $proveedor = Proveedor::findOrFail($request->id); 
        $cliente = Persona::findOrFail($request->id);
        $cliente->nombre = $request->nombre;
        $cliente->razon_social = $request->razon_social;
        $cliente->direccion = $request->direccion;
        $cliente->telefono = $request->telefono;
        $cliente->correo = $request->correo;
        $cliente->save();
    }

    public function listarCbo(Request $request){
        if(!$request->ajax())return redirect('/');
        $proveedor = Proveedor::join('personas as p','p.id','=','proveedores.id')
        ->select('proveedores.id','p.tipo_documento','p.num_documento','p.nombre','p.razon_social')
        ->where('p.estado','=','1')->get();
        return compact('proveedor');
    }

   

}
