<?php

namespace App\Http\Controllers;
use Intervention\Image\Facades\Image;
use App\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $producto = Producto::Join('categorias as c','c.id','=','productos.idcategoria')
        ->select('productos.id','productos.codigo','productos.descripcion',
        'productos.unidad_medida','productos.stock','productos.precio_compra','productos.precio_venta',
        'productos.estado','productos.ruta','c.id as idcategoria','c.nombre as categoria')->get();
        return compact('producto');
    }

    public function store(Request $request)
    {

        $input['idcategoria'] = $request->input('idcategoria');
        $input['codigo'] = $request->input('codigo'); 
        $input['descripcion'] = $request->input('descripcion'); 
        $input['unidad_medida'] = $request->input('unidad_medida'); 
        $input['stock'] = $request->input('stock'); 
        $input['precio_compra'] = $request->input('precio_compra'); 
        $input['precio_venta'] = $request->input('precio_venta'); 

       
        if ($request->file('ruta') == null || empty($request->file('ruta'))){
            $input['ruta'] = 'thumbnail/default/anonymous.png';
        }
        else{

        $originalImage= $request->file('ruta');
        $thumbnailImage = Image::make($originalImage);
        $thumbnailPath = public_path().'/thumbnail/';
        
        if (!file_exists($thumbnailPath)) {
            mkdir($thumbnailPath, 666, true);
        }
        // $thumbnailImage->resize(150,150);
        $thumbnailImage->resize(100,100);
        $randon = time().$originalImage->getClientOriginalName();
        $thumbnailImage->save($thumbnailPath.''.$randon); 
        $input['ruta'] = 'thumbnail/'.$randon;
      }

      $data = Producto::insert($input);

        // Producto::create($request->all());
    }

    public function edit(Request $request)
    {
        $id = $request->input('id');
        $idcategoria = $request->input('idcategoria');
        $codigo = $request->input('codigo'); 
        $descripcion  = $request->input('descripcion'); 
        $unidad_medida = $request->input('unidad_medida'); 
        $stock = $request->input('stock');
        $precio_compra = $request->input('precio_compra');
        $precio_venta = $request->input('precio_venta');
        
        if($request->input('ruta') == $request->input('imagenActual')){
            $ruta = $request->input('imagenActual');
        }else  if ($request->file('ruta') == null || empty($request->file('ruta'))){
            $ruta = 'thumbnail/default/anonymous.png';
        }else{

            if($request->input('imagenActual') != 'thumbnail/default/anonymous.png'){
                unlink($request->input('imagenActual'));
            }

            $originalImage= $request->file('ruta');
            $thumbnailImage = Image::make($originalImage);
            $thumbnailPath = public_path().'/thumbnail/';
            
            if (!file_exists($thumbnailPath)) {
                mkdir($thumbnailPath, 666, true);
            }
            $thumbnailImage->resize(100,100);
            $randon = time().$originalImage->getClientOriginalName();
            $thumbnailImage->save($thumbnailPath.''.$randon); 
            $ruta = 'thumbnail/'.$randon;
        }

        $data = Producto::where('id', $id)->update([
            'idcategoria' => $idcategoria,
            'codigo' => $codigo,
            'descripcion' => $descripcion,
            'unidad_medida' => $unidad_medida,
            'stock' => $stock,
            'precio_compra' => $precio_compra,
            'precio_venta' => $precio_venta,
            'ruta' => $ruta
        ]);
        
        
        return $data;
    }

    public function buscarProductoIngreso(Request $request){
        if (!$request->ajax()) return redirect('/');
        $filtro = $request->filtro;
        $productos = Producto::Join('categorias as c','c.id','=','productos.idcategoria')
        ->select('productos.id','productos.codigo','productos.descripcion',
        'productos.precio_compra','productos.stock','productos.unidad_medida','productos.stock',
        'productos.estado','productos.ruta','c.id as idcategoria','c.nombre as categoria')
        ->where('productos.codigo','=', $filtro)
        ->orderBy('productos.descripcion', 'asc')
        ->take(1)->get();
        return compact('productos');
    }
    
    public function buscarProductoVenta(Request $request){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        if ($filtro==''){
            $productos = Producto::Join('categorias as c','c.id','=','productos.idcategoria')
            ->select('productos.id','productos.codigo','productos.descripcion',
            'productos.precio_venta','productos.precio_compra','productos.stock','productos.unidad_medida','productos.stock',
            'productos.estado','productos.ruta','c.id as idcategoria','c.nombre as categoria')
            ->where('productos.stock','>','0')
            ->where('productos.estado','=','1')
            ->orderBy('productos.descripcion', 'asc')->get();
        }else{
            $productos = Producto::Join('categorias as c','c.id','=','productos.idcategoria')
            ->select('productos.id','productos.descripcion','productos.precio_venta','productos.precio_compra','productos.unidad_medida','productos.stock')
            ->where('productos.codigo','=', $filtro)
            ->where('productos.stock','>','0')
            ->where('productos.estado','=','1')
            ->orderBy('productos.descripcion', 'asc')
            ->take(1)->get();
        }
        return compact('productos');
    }


    public function update(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $estado = $request->estado;
        $producto = Producto::findOrFail($request->id);
       
        if($estado){
            $producto->estado = 0;
        }else{
            $producto->estado = 1;
        }
       
        $producto->save();
    }

    public function listarPdf(){
        $productos = Producto::Join('categorias as c','c.id','=','productos.idcategoria')
        ->select('productos.codigo','productos.descripcion',
        'productos.precio_venta','productos.precio_compra','productos.stock',
        'productos.unidad_medida','productos.stock','c.nombre as categoria','productos.estado')
        ->orderBy('productos.descripcion')->get();

        $cont = Producto::count();
        $pdf = \PDF::loadView('pdf.productospdf',['productos'=>$productos,'cont'=>$cont])->setPaper('a4', 'portrait');
        return $pdf->stream('productos.pdf');
        
    }
}
