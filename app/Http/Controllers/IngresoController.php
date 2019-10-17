<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Ingreso;
use App\DetalleIngreso;

class IngresoController extends Controller
{


    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $ingresos = Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
            ->join('users','ingresos.idusuario','=','users.id')
            ->select('ingresos.id','ingresos.tipo_comprobante','ingresos.serie_comprobante',
            'ingresos.numero_comprobante','ingresos.created_at as fecha','ingresos.total',
            'ingresos.estado','personas.nombre','personas.razon_social','users.usuario')
            ->orderBy('ingresos.id', 'desc')->paginate(10);
        }
        else{
            $ingresos = Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
            ->join('users','ingresos.idusuario','=','users.id')
            ->select('ingresos.id','ingresos.tipo_comprobante','ingresos.serie_comprobante',
            'ingresos.numero_comprobante','ingresos.created_at as fecha','ingresos.total',
            'ingresos.estado','personas.nombre','personas.razon_social','users.usuario')
            ->where('ingresos.'.$criterio, 'like', '%'. $buscar . '%')->orderBy('ingresos.id', 'desc')->paginate(10);
        }
        
        return [
            'pagination' => [
                'total'        => $ingresos->total(),
                'current_page' => $ingresos->currentPage(),
                'per_page'     => $ingresos->perPage(),
                'last_page'    => $ingresos->lastPage(),
                'from'         => $ingresos->firstItem(),
                'to'           => $ingresos->lastItem(),
            ],
            'ingresos' => $ingresos
        ];
    }


    public function store(Request $request){
        try{
            DB::beginTransaction();

            $ingreso = new Ingreso();
            $ingreso->idproveedor = $request->idproveedor;
            $ingreso->idusuario = \Auth::user()->id;
            $ingreso->tipo_comprobante = $request->tipo_comprobante;
            $ingreso->serie_comprobante = $request->serie_comprobante;
            $ingreso->numero_comprobante = $request->numero_comprobante;
            $ingreso->total = $request->total;
            $ingreso->estado = 'Registrado';
            $ingreso->save();

            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos

            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetalleIngreso();
                $detalle->idingreso = $ingreso->id;
                $detalle->idproducto = $det['idproducto'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio = $det['precio'];          
                $detalle->save();
            }

            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }
    }

    
    public function numeroComprobante(Request $request) {
        $tipo = $request->tipo;
        $numero = Ingreso::select(DB::raw('COUNT(id) as id'))
        ->where('tipo_comprobante', '=',$tipo)->take(1)->get();
        return compact('numero');
    }


    public function obtenerCabecera(Request $request){
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;

        $ingreso = Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
        ->join('users','ingresos.idusuario','=','users.id')
        ->select('ingresos.id','ingresos.tipo_comprobante',
        'ingresos.numero_comprobante','ingresos.created_at as fecha','ingresos.total',
        'ingresos.estado','personas.nombre','personas.num_documento','personas.direccion','personas.telefono','personas.razon_social','users.usuario')
        ->where('ingresos.id','=',$id)
        ->orderBy('ingresos.id', 'desc')->get();
        
       return compact('ingreso');
    }


    public function obtenerDetalles(Request $request){
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $detalles = DetalleIngreso::join('productos','detalle_ingresos.idproducto','=','productos.id')
        ->select('detalle_ingresos.cantidad','detalle_ingresos.precio','productos.descripcion')
        ->where('detalle_ingresos.idingreso','=',$id)
        ->orderBy('detalle_ingresos.id', 'desc')->get();
        
        return compact('detalles');

    }


    
    public function anularIngreso(Request $request)
    {
        $ingreso  = Ingreso::findOrFail($request->id);
        $ingreso->estado = 'Anulado';
        $ingreso->save();
    }
}
