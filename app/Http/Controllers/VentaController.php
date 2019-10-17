<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Venta;
use App\DetalleVenta;
use App\Empresa;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{


    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){

            $ventas = Venta::join('personas','ventas.idcliente','=','personas.id')
            ->join('users','ventas.idusuario','=','users.id')
            ->select('ventas.id','ventas.tipo_comprobante','ventas.serie_comprobante',
            'ventas.numero_comprobante','ventas.created_at as fecha','ventas.credito_fiscal','ventas.total',
            'ventas.estado','personas.nombre','personas.razon_social','users.usuario')
            ->orderBy('ventas.created_at', 'desc')->paginate(10);
        }
        else{
            $ventas = Venta::join('personas','ventas.idcliente','=','personas.id')
            ->join('users','ventas.idusuario','=','users.id')
            ->select('ventas.id','ventas.tipo_comprobante','ventas.serie_comprobante',
            'ventas.numero_comprobante','ventas.created_at as fecha','ventas.credito_fiscal','ventas.total',
            'ventas.estado','personas.nombre','personas.razon_social','users.usuario')
            ->where('ventas.'.$criterio, 'like', '%'. $buscar . '%')->orderBy('ventas.id', 'desc')->paginate(10);
        }
        
        return [
            'pagination' => [
                'total'        => $ventas->total(),
                'current_page' => $ventas->currentPage(),
                'per_page'     => $ventas->perPage(),
                'last_page'    => $ventas->lastPage(),
                'from'         => $ventas->firstItem(),
                'to'           => $ventas->lastItem(),
            ],
            'ventas' => $ventas
        ];
    }



    public function store(Request $request){
        try{
            DB::beginTransaction();

            $venta = new Venta();
            $venta->idcliente = $request->idcliente;
            $venta->idusuario = \Auth::user()->id;
            $venta->tipo_comprobante = $request->tipo_comprobante;
            $venta->serie_comprobante = $request->serie_comprobante;
            $venta->numero_comprobante = $request->numero_comprobante;
            $venta->credito_fiscal = $request->credito_fiscal;
            $venta->total = $request->total;
            $venta->estado = 'Registrado';
            $venta->save();

            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos

            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetalleVenta();
                $detalle->idventa = $venta->id;
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
        if (!$request->ajax()) return redirect('/');
        $tipo = $request->tipo;
        $numero = Venta::select(DB::raw('COUNT(id) as id'))
        ->where('tipo_comprobante', '=',$tipo)->take(1)->get();
        return compact('numero');
    }


    public function obtenerCabecera(Request $request){
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;

        $venta = Venta::join('personas','ventas.idcliente','=','personas.id')
        ->join('users','ventas.idusuario','=','users.id')
        ->select('ventas.id','ventas.tipo_comprobante','ventas.numero_comprobante',
        'ventas.created_at as fecha','ventas.total','ventas.estado',
        'personas.nombre','personas.tipo_documento','personas.num_documento','personas.direccion','personas.telefono','personas.razon_social','users.usuario')
        ->where('ventas.id','=',$id)
        ->orderBy('ventas.id', 'desc')->get();
        
       return compact('venta');
    }

    
    public function obtenerDetalles(Request $request){
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $detalles = DetalleVenta::join('productos','detalle_ventas.idproducto','=','productos.id')
        ->select('detalle_ventas.cantidad','detalle_ventas.precio','productos.descripcion','productos.unidad_medida')
        ->where('detalle_ventas.idventa','=',$id)
        ->orderBy('detalle_ventas.id', 'desc')->get();
        
        return compact('detalles');

    }

    public function anularVenta(Request $request)
    {
        $venta  = Venta::findOrFail($request->id);
        $venta->estado = 'Anulado';
        $venta->save();
    }

    public function idVenta(Request $request)
    {
        $ventaid = Venta::max('id');
        return $ventaid;
    }


    public function listarPdfVenta(Request $request){
        $id = $request->id;
        $venta = Venta::join('personas','ventas.idcliente','=','personas.id')
        ->join('users','ventas.idusuario','=','users.id')
        ->select('ventas.serie_comprobante','ventas.tipo_comprobante','ventas.numero_comprobante',
        'ventas.created_at as fecha','ventas.total','ventas.estado',
        'personas.nombre','personas.tipo_documento','personas.num_documento','personas.direccion','personas.telefono','personas.razon_social','users.usuario')
        ->where('ventas.id','=',$id)
        ->orderBy('ventas.id', 'desc')->get();

        $detalles = DetalleVenta::join('productos','detalle_ventas.idproducto','=','productos.id')
        ->select('detalle_ventas.cantidad','detalle_ventas.precio','productos.codigo','productos.descripcion','productos.unidad_medida')
        ->where('detalle_ventas.idventa','=',$id)
        ->orderBy('detalle_ventas.id', 'desc')->get();

        $empresa=Empresa::get();

        $cont=Venta::count();

        $numventa=Venta::select('numero_comprobante')->where('id',$id)->get();

        $pdf = \PDF::loadView('pdf.ventapdf',['venta'=>$venta,'detalles'=>$detalles,'empresa'=>$empresa]);
        return $pdf->stream('venta-'.$numventa[0]->numero_comprobante.'.pdf');
    }

    
    public function ticket(Request $request,$id){
        $venta = Venta::join('personas','ventas.idcliente','=','personas.id')
        ->join('users','ventas.idusuario','=','users.id')
        ->select('ventas.serie_comprobante','ventas.tipo_comprobante','ventas.numero_comprobante',
        'ventas.created_at as fecha','ventas.total','ventas.estado',
        'personas.nombre','personas.tipo_documento','personas.num_documento','personas.direccion','personas.telefono','personas.razon_social','users.usuario')
        ->where('ventas.id','=',$id)
        ->orderBy('ventas.id', 'desc')->get();

        $detalles = DetalleVenta::join('productos','detalle_ventas.idproducto','=','productos.id')
        ->select('detalle_ventas.cantidad','detalle_ventas.precio','productos.codigo','productos.descripcion','productos.unidad_medida')
        ->where('detalle_ventas.idventa','=',$id)
        ->orderBy('detalle_ventas.id', 'desc')->get();

        $empresa=Empresa::get();

        $cont=Venta::count();

        $numventa=Venta::select('numero_comprobante')->where('id',$id)->get();

        $customPaper = array(50,-30,567.00,300.80);

        $pdf = \PDF::loadView('pdf.ticket',['venta'=>$venta,'detalles'=>$detalles,'empresa'=>$empresa])->setPaper($customPaper, 'landscape');
        return $pdf->stream('ticketventa-'.$numventa[0]->numero_comprobante.'.pdf');
    }


}

