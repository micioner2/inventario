<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;

class CategoriaController extends Controller
{
    public function index (Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $categoria = Categoria::get();

        return ['categoria'=>$categoria];
    }

    public function store(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        Categoria::create($request->all());
        
    }

    public function edit(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $categoria = Categoria::findOrFail($request->id);
        $categoria->nombre = $request->nombre;
        $categoria->estado = 1;
        $categoria->save();
    }

    public function update(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $estado = $request->estado;
        $categoria = Categoria::findOrFail($request->id);
       
        if($estado){
            $categoria->estado = 0;
        }else{
            $categoria->estado = 1;
        }
       
        $categoria->save();
    }

    public function cboCategoria(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $categoria = Categoria::where('estado','=','1')->get();
        return ['categoria' => $categoria];
    }
}
