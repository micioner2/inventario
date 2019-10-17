<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function rangoFechaVenta(Request $request){
        if(!$request->ajax())return redirect('/');
        $anio = date('Y');
        $venta=DB::table('ventas as v')
        ->select(DB::raw('MONTH(v.created_at) as mes'),
        DB::raw('YEAR(v.created_at) as anio'),
        DB::raw('SUM(v.total) as total'))
        ->where('v.estado','=','Registrado')
        ->whereYear('v.created_at', $anio)
        ->groupBy(DB::raw('MONTH(v.created_at)'), DB::raw('YEAR(v.created_at)'))
        ->get();
        return compact('venta');
    }

    public function rangoFechaIngreso(Request $request){
        if(!$request->ajax())return redirect('/');
        $anio = date('Y');
        $ingreso=DB::table('ingresos as i')
        ->select(DB::raw('MONTH(i.created_at) as mes'),
        DB::raw('YEAR(i.created_at) as anio'),
        DB::raw('SUM(i.total) as total'))
        ->where('i.estado','=','Registrado')
        ->whereYear('i.created_at', $anio)
        ->groupBy(DB::raw('MONTH(i.created_at)'), DB::raw('YEAR(i.created_at)'))
        ->get();
        return compact('ingreso');
    }

    public function donaProductos(Request $request)
    {
        // if(!$request->ajax())return redirect('/');
        $mes = date('m');
        $productos = DB::table('productos')->join('detalle_ventas as dv','dv.idproducto','=','productos.id')
        ->join('ventas as v','dv.idventa','=','v.id')
        ->select(DB::raw('SUM(dv.cantidad) as cantidad'),'productos.descripcion','productos.ruta')
        ->where('v.estado','=','Registrado')
        ->whereMonth('v.created_at',$mes)
        ->groupBy('productos.id','productos.descripcion','productos.ruta')
        ->orderBY('cantidad','desc')->take(5)->get();

        return['productos'=> $productos];
    }


      
    public function smallBoxes(Request $request){
        if(!$request->ajax())return redirect('/');
        $clientes = DB::table('personas')->where('estado','=','1')->count();
        $productos = DB::table('productos')->where('estado','=','1')->count();
        $ventas = DB::table('ventas')->select(DB::raw('SUM(total) as total'))->where('estado','=','Registrado')->get();
        $ingresos = DB::table('ingresos')->select(DB::raw('SUM(total) as total'))->where('estado','=','Registrado')->get();  
        return ['clientes'=>$clientes,'productos'=>$productos,'ventas'=>$ventas,'ingresos'=>$ingresos];
    }

    public function listarProductosSinStock(Request $request){
        if(!$request->ajax())return redirect('/');
        $productos = DB::table('productos')
        ->select('ruta','descripcion','stock')
        ->where('stock','<','10')
        ->where('estado','=','1')->orderBy('stock','desc')
        ->take(10)->get();
        return  compact('productos');
    }



}



