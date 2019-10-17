
<!DOCTYPE>
<html>
    <html lang="es">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @foreach($venta as $v)
    <title>{{$v->serie_comprobante}}-{{$v->numero_comprobante}}</title>
    @endforeach
    <style>
        @charset "utf-8";
    
        body {
            margin: 10px;
            padding: 0;
            padding-bottom: 1px;
            font-size: 11px;
            
        }

        body, td, th {
            font-family: Arial, Helvetica, sans-serif;
            text-align:center;
            font-size:11px;
        }

        .zona_impresion{
            width: 340px;
            padding:10px 5px 10px 5px;
        }
 
    </style>
    <body>
    <div class="zona_impresion">
        <!-- codigo imprimir -->
        <br>
        @foreach ($empresa as $en)
        <table border="0" align="center" width="300px"   style="margin-bottom:-8px;" >
            <tr>
                <td align="center">

                    .::<strong> {{$en->razon_social}} </strong>::.<br>
                    {{$en->direccion}} <br>
                    {{$en->telefono}}<br>
                    R.U.C: {{$en->ruc}}
                </td>
            </tr>
        </table>
        @endforeach
        @foreach ($venta as $v)

        <table border="0" align="center" width="300px" style="margin-bottom:-8px;">
            <tr>
                <td>........................................................................................<br>
                    <strong>{{$v->tipo_comprobante}} ELECTRONICA</strong> <br>
                   {{$v->serie_comprobante}} -  {{$v->numero_comprobante}}
                    ........................................................................................
                </td>
            </tr>
        </table>

        <table border="0" width="300px">
            <tr>
                <td>Fecha: {{ \Carbon\Carbon::parse($v->fecha)->format('d/m/Y')}}</td>
                <td>Hora:  {{ \Carbon\Carbon::parse($v->fecha)->format('H:i')}}</td>
            </tr>
        </table>

        <table border="0" width="160px" style="margin-bottom:-15px;">
            <tr>
                <td>Caj.    {{$v->usuario}}</td>
            </tr>
        </table>

        <table border="0" width="340px" >
            <tr>
                <td>........................................................................................</td>
            </tr>
        </table>

        <table border="0" width="350px"  style="margin-bottom:-15px;">         
        <tr>
                @if($v->tipo_comprobante != 'FACTURA')
                    <td>Cliente: {{$v->nombre}}</td>
                @else
                    <td>Cliente: {{$v->razon_social}}</td>
                @endif
            </tr>


            <tr>
                <td>{{$v->tipo_documento}}:  {{$v->num_documento}}</td>
            </tr>
            
        </table>

        
        <table border="0" width="340px" >
            <tr>
                <td>........................................................................................</td>
            </tr>
        </table>

        @endforeach
        <br>
        <!-- Mostramos los detalles de la venta en el documento HTML -->
        <table border="0" align="center" width="300px">
            <tr>
                <td colspan="4">----------------------------------------------------------------------------------------------------------</td>
            </tr> 
            <tr style="font-weight:bold;">
                <td>CANT.</td>
                <td>DESCRIPCION</td>
                <td>P.UNT.</td>
                <td align="right">IMPORTE</td>
            </tr>
            <tr>
            <td colspan="4">----------------------------------------------------------------------------------------------------------</td>
            </tr>            
            
            @foreach ($detalles as $det)
            <tr>
                <td >{{$det->cantidad}} {{$det->unidad_medida}}</td>
                <td style="width:100%; font-size:9px;">{{$det->descripcion}}</td>
                <td>{{$det->precio}}</td>
                <td>{{number_format(($det->precio * $det->cantidad),2)}}</td>
            </tr>
            @endforeach
            <!-- Mostramos los totales de la venta en el documento HTML -->
            <tr>
            <td colspan="4">===============================================</td>
            </tr>   
            @foreach ($venta as $v)

            <tr>
                <td align="right">SUBTOTAL:</td>
                <td></td><td></td>
                <td> S/.{{number_format($v->total-($v->total*0.18),2)}}</td>
            </tr>

            <tr>
                <td align="right">IGV:</td>
                <td></td><td></td>
                <td>S/.{{number_format(($v->total*0.18),2)}}</td>
                </tr>
            <tr>
                <td align="right">TOTAL:</td>
                <td></td><td></td>
                <td>S/.{{number_format(($v->total)-($v->descuento),2)}}</td>
            </tr>
            @endforeach
            <tr>
            <td colspan="4">&nbsp;</td>
            </tr>
            @foreach ($empresa as $en)    
            <tr>
            <td colspan="4" align="center">隆Gracias por su preferencia!</td>
            </tr>
            <tr>
            <td colspan="4" align="center">{{$en->razon_social}}</td>
            </tr>           
            <tr>
            <td colspan="4" align="center">
                <p>
                    Esta es una representaci贸n impresa del documento de venta.
                </p>
            </td>
            </tr>
            @endforeach
        </table>
        <br>
        </div>
    </body>
</html>