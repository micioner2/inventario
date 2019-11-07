<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\reniec\reniec;
use App\reniec\curl;

class PersonaController extends Controller
{

    public function listClientes(Request $request){

        $cliente = Persona::where('tipo_persona','Cliente')
        ->orderBy('id','asc')->get();
        return compact('cliente');
    }

    public function listProveedores(Request $request){

        $proveedor = Persona::where('tipo_persona','Proveedor')
        ->orderBy('id','asc')->get();
        return compact('proveedor');
    }


    public function store(Request $request)
    {
        $cliente = new Persona();
        $cliente->tipo_persona = $request->tipo_persona;
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
        $cliente->tipo_persona = $request->tipo_persona;
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

   
    public function consultaApiSunat(Request $request)
    {
        $num_documento = $request->num_documento;
        $tipo_documento = $request->tipo_documento;
        $nombre = "";
        if ($tipo_documento == "DNI") {
            $nombre = json_encode(file_get_contents("https://reniec.plataformavensys.com/Consultar.php?dni=".$num_documento),true);
            
        }else{
            $nombre = json_decode(file_get_contents("https://api.sunat.cloud/ruc/".$num_documento),true);
        }
        return str_replace('|', ' ', $nombre);
    }

    public function buscarDni(Request $request)
    { 
            $data = [];
            $persona = new Reniec();
            $dni = $request->dni;
            $yo = $persona->search( $dni );
            if (is_null($yo)) {
                $data=array('estado' => false);
                json_encode($data);
            }else{
                if( $yo->success==true )
                {
                    $data=array(
                        // 'dni' => $yo->result->DNI,
                        // 'codveri' => $yo->result->CodVerificacion,
                        'nombres' => $yo->result->Nombres,
                        'apellidos' => $yo->result->Apellidos,
                        // 'grupovota' => $yo->result->gvotacion,
                        // 'distrito' => $yo->result->Distrito,
                        // 'provincia' => $yo->result->Provincia,
                        'departamento' => $yo->result->Departamento,
                        'estado' => $yo->success
                    );
                    
                }else{
                    $data=array('estado' => $yo->success);
                }           
            }

        return  json_encode($data);
    }

    public function buscarRuc(Request $request){
        $endpoint = "https://api.migoperu.pe/api/v1/ruc";
        $token = "598bbb5e-100e-4eae-9fb8-d598a5cf7fd2-a7a81134-9d06-44ba-86bc-75c31be3278b";
        $ruc = $request->ruc;
        $data = array(
            "token"	=> $token,
            "ruc"   => $ruc
        );

        $ch = curl_init($endpoint);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
            )
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $json = curl_exec($ch);
        curl_close($ch);

       return json_decode($json, true);
    }

}
