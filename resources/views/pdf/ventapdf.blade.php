<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Venta</title>
    <style>
        body {
        font-family: Arial, sans-serif; 
        font-size: 14px;
        }

        #logo{
        float: left;
        margin-top: 1%;
        margin-left: 2%;
        margin-right: 2%;
        }

        #imagen{
        width: 100px;
        }

        #datos{
        float: left;
        margin-top: 0%;
        margin-left: 2%;
        margin-right: 2%;
        }

        #encabezado{
        text-align: center;
        margin-left: 10%;
        margin-right: 35%;
        font-size: 15px;
        }

        .fact{
            float: right;
            margin-top: 2%;
            margin-left: 2%;
            margin-right: 2%;
            font-size: 15px;
            border-style: solid;
            border-width: 1px;
            border-color: #CA4529;
            border-radius: 5px;
            padding:5px;
        }

     

        #facliente thead{
        padding: 20px;
        background: #2183E3;
        text-align: left;
        border-bottom: 1px solid #FFFFFF;  
        }


  

        #faproducto{
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
            text-align: center;
        }

        #faproducto thead{
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #FFFFFF;  
        }

        .table{
            border-collapse: collapse;
        }

        .centrado, th, td {
            border: 1px solid black;
        }

        .table td{
            height: 25px;
            vertical-align: bottom;
        }

        .table-detalle td, th{
            padding:5px;
            font-size:12px;
        }


        #gracias{
        text-align: center; 
        }
    </style>
    <body>

        <header>
        @foreach($empresa as $en)
            <div id="logo">
                <img src="{{$en->ruta}}" alt="incanatoIT" id="imagen">
            </div>
            <div id="datos">
                <p id="encabezado">
                    <b>{{$en->razon_social}}</b> <br>R.U.C: {{$en->ruc}}<br>{{$en->direccion}}<br>Telefono: {{$en->telefono}}
                </p>
            </div>
        @endforeach
        @foreach ($venta as $v)
            <div class="fact">
                <p>{{$v->tipo_comprobante}}<br>
                {{$v->serie_comprobante}}-{{$v->numero_comprobante}}</p>
            </div>
        </header>
        <br>
        <section>
            <div>
                <h3 class="text-center" style="border-bottom: 1px solid black;">Cliente</h3>

                    <table class="table table-detalle">
                  
                        <tr>
                            <td style="border: 1px solid #666; background-color:white; width:390px;"> <b style="font-size:13px;">Cliente:</b> 
                            @if($v->tipo_comprobante != 'FACTURA')
                                    {{$v->nombre}}
                                @else
                                    {{$v->razon_social}}
                            @endif
                            </td>
                            <td style="border: 1px solid #666; background-color:white; width:290px"> <b style="font-size:13px;">{{$v->tipo_documento}}:</b>   {{$v->num_documento}}</td>
                        </tr>

                    </table>

                    <table class="table table-detalle">
                        <tr>
                        <td style="border: 1px solid #666; background-color:white; width:390px"> <b style="font-size:13px;">Dirección:</b>  {{$v->direccion}}</td>
                            <td style="border: 1px solid #666; background-color:white; width:290px;"> <b style="font-size:13px;">Teléfono:</b> {{$v->telefono}}</td>
                        </tr>
                    </table>
                    <br>

                    <h3 class="text-center" style="border-bottom: 1px solid black;">Vendedor</h3>
                    <table class="table table-detalle">
                        <tr>
                            <td style="border: 1px solid #666; background-color:white; width:390px"> <b style="font-size:13px;">Vendedor:</b>  {{$v->usuario}}</td>
                            <td style="border: 1px solid #666; background-color:white; width:290px;"> <b style="font-size:13px;">Fecha:</b> {{$v->fecha}}</td>
                        </tr>
                    </table>
            </div>
        </section>
        @endforeach
        <br>
        <section>
            <div>
            <h3 class="text-center" style="border-bottom: 1px solid black;">Detalle de venta</h3>
                <table id="faproducto" class="table">
                    <thead>
                        <tr id="fa" style=" background-color: lightgrey;">
                            <th>CODIGO</th>
                            <th>CANT</th>
                            <th>DESCRIPCION</th>
                            <th>P.UNIT.</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detalles as $det)
                        <tr class="centrado">
                            <td>{{$det->codigo}}</td>
                            <td>{{$det->cantidad}} {{$det->unidad_medida}}</td>
                            <td>{{$det->descripcion}}</td>
                            <td>{{$det->precio}}</td>
                            <td>{{number_format(($det->precio * $det->cantidad),2)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <table class="table table-detalle" style="margin-left:360px;">
                        @foreach ($venta as $v)

                        <tr>
                            <th style="border: 1px solid #666;  background-color:white; width:100px; text-align:center">
                                SUBTOTAL
                            </th>
                            <td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
                            {{number_format($v->total-($v->total*0.18),2)}}
                            </td>
                        </tr>

                        <tr>
                            <th style="border: 1px solid #666;  background-color:white; width:100px; text-align:center">
                                IGV
                            </th>
                            <td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
                            {{number_format(($v->total*0.18),2)}}
                            </td>
                        </tr>

                        <tr>
                            <th style="border: 1px solid #666;  background-color:white; width:100px; text-align:center">
                                TOTAL
                            </th>
                            <td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center;">
                            {{$v->total}}
                            </td>
                        </tr>
                        @endforeach
             
                </table>
            </div>
        </section>
        <br>
        <br>
        <footer>
            <div id="gracias">
                <p><b>Gracias por su compra!</b></p>
            </div>
        </footer>
    </body>
</html>