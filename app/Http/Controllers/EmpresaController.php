<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Empresa;

class EmpresaController extends Controller
{
    public function index(Request $request){
        $empresa = Empresa::take(1)->get();
       return compact('empresa');
    }

    public function store(Request $request){

        $input['razon_social'] = $request->input('razon_social');
        $input['ruc'] = $request->input('ruc'); 
        $input['direccion'] = $request->input('direccion'); 
        $input['telefono'] = $request->input('telefono'); 
        $input['ruta'] = $request->input('ruta');
        
        if ($request->file('ruta') == null || empty($request->file('ruta'))){
            $input['ruta'] = 'logo_empresa/logo-compania.png';
        }else{
            $originalImage= $request->file('ruta');
            $thumbnailImage = Image::make($originalImage);
            $thumbnailPath = public_path().'/logo_empresa/';
            if (!file_exists($thumbnailPath)) {
                mkdir($thumbnailPath, 666, true);
            }
            // $thumbnailImage->resize(300,300);
            $randon = time().$originalImage->getClientOriginalName();
            $thumbnailImage->save($thumbnailPath.''.$randon); 
            $input['ruta'] = 'logo_empresa/'.$randon;
        }

        $data = Empresa::insert($input);
 
    }

    public function edit(Request $request){
        $id = $request->input('id');
        $razon_social = $request->input('razon_social');
        $ruc = $request->input('ruc'); 
        $direccion = $request->input('direccion'); 
        $telefono = $request->input('telefono'); 
        $ruta = $request->input('ruta');

        if($request->input('ruta') == $request->input('imagenActual')){
            $ruta = $request->input('imagenActual');
        }else if ($request->file('ruta') == null || empty($request->file('ruta'))){
            $ruta = 'logo_empresa/logo-compania.png';
        }else{

            if($request->input('imagenActual') != 'logo_empresa/logo-compania.png'){
                unlink($request->input('imagenActual'));
            }

            $originalImage= $request->file('ruta');
            $thumbnailImage = Image::make($originalImage);
            $thumbnailPath = public_path().'/logo_empresa/';
            
            if (!file_exists($thumbnailPath)) {
                mkdir($thumbnailPath, 666, true);
            }
            $thumbnailImage->resize(100,100);
            $randon = time().$originalImage->getClientOriginalName();
            $thumbnailImage->save($thumbnailPath.''.$randon); 
            $ruta = 'logo_empresa/'.$randon;
        }

        $data = Empresa::where('id', $id)->update([
            'razon_social' => $razon_social,
            'ruc' => $ruc,
            'direccion' => $direccion,
            'telefono' => $telefono,
            'ruta' => $ruta
        ]);
        
        return $data;


    }
}
