<template>
    <div class="row">
        <!--TABLA VENTA -->
        <div class="col-lg-12 col-xs-12">
           
            <div class="box box-danger">
                <div class="box box-default">
                    <div class="box-header with-border text-center">
                        <h3 class="box-title" style="color:red;">Ventas</h3>
                    </div>

                    <div class="box-body with-border">
                        <div class="row">
                            <div class="col">

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="button" @click="myTable()" class="btn btn-primary btnagregar" data-toggle="modal" data-target="#modalProducto"><i class="fa fa-search"></i>&nbsp;&nbsp;Listar Productos</button>
                                    </div>
                                </div>
                                    

                                <div class="hidden-sm hidden-xs">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>CODIGO DEL PRODUCTO</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Ingrese codigo" v-model="codigo" @keyup.enter="buscarProducto()" maxlength="20" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary" type="button" @click="buscarProducto()"><i class="fa fa-search"></i>&nbsp;&nbsp;Buscar..</button>
                                                </span>
                                            </div>
                                            <input style="font-weight:bold;" type="text" readonly class="form-control" v-model="descripcion">                               
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>PRECIO</label>
                                            <input type="number" value="0" step="any" class="form-control" v-model="precio">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>CANTIDAD </label>
                                               <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button  class="btn btn-primary" type="button" @click="cantidadPrincipal('-')"><i class="fa fa-minus"></i></button>
                                                </span>
                                                    <input type="number" class="form-control text-center personalizado" min="1" value="1" v-model.number="cantidad">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary" type="button"  @click="cantidadPrincipal('+')"><i class="fa fa-plus"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-success form-control btnagregar" @click="agregarDetalle()"><i class="fa fa-plus"></i>&nbsp;&nbsp;</button>
                                        </div>
                                    </div>

                                </div>
                                    
                                <!-- <div class="col-md-12 hidden-md hidden-lg">
                                    <div class="form-group">
                                        <button type="button" @click="myTable()" class="btn btn-primary" data-toggle="modal" data-target="#modalProducto"><i class="fa fa-search"></i>&nbsp;&nbsp;Listar Productos</button>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                        <div class="table table-responsive" v-if="arrayDetalle.length">
                            <table class="table table-bordered">
                                <thead class="cabecera">
                                    <tr>
                                        <th>OPCION</th>
                                        <th class="text-center" style="width:40%">PRODUCTO</th>
                                        <th>UND</th>
                                        <th>CANTIDAD</th>
                                        <th>PRECIO</th>
                                        <th>IMPORTE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item,index) in arrayDetalle" :key="index">
                                        <td>
                                            <button type="button" @click="eliminarItem(index)" class="btn btn-danger"><i class="fa fa-times"></i></button>
                                        </td>
                                        <td class="text-center"> 
                                            <b v-text="item.descripcion"></b>
                                        </td>
                                        <td v-text="item.unidad_medida">
                                            
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button  class="btn btn-primary" type="button" @click="cantidadDetalle('-',item)"><i class="fa fa-minus"></i></button>
                                                </span>
                                                    <input type="number" class="form-control input-lg text-center personalizado" min="1" value="1" v-model.number="item.cantidad">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary" type="button"  @click="cantidadDetalle('+',item)"><i class="fa fa-plus"></i></button>
                                                </span>
                                            </div>
                                            <span v-show="item.cantidad > item.stock " class="label label-danger">Cantidad mayor al Stock</span>
                                            <span v-show="item.cantidad <= 0 " class="label label-danger">Cantidad mayor que 1</span>
                                        </td>

 
                                        <td>
                                            <span style="color:red;"  v-show="item.precio <= 0 ">Precio > 0</span>
                                            <input type="number" class="form-control input-lg personalizado" v-model="item.precio">
                                        </td>
                                        <td class="personalizado">
                                             <input type="number" class="form-control input-lg personalizado" :value="(item.precio * item.cantidad).toFixed(2)" disabled>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="box-footer with-border">
                        <button v-if="arrayDetalle.length" class="btn btn-info pull-left" @click="listarClientes()" data-toggle="modal" data-target="#modal-detalle" data-backdrop="static" data-keyboard="false"><i class="fa fa-eye"></i>&nbsp;&nbsp;Ver Detalle venta</button>
                    </div>
                </div>
            </div>
        </div>

        <!--DETALLE VENTA -->
        <div class="modal fade" id="modal-detalle">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modales">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">DETALLE DE VENTA</h4>
                    </div>
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <div class="box-header with-border">
                                <div class="div-total">
                                    <h2 class="text-center">S/ {{(calcularTotal).toFixed(2)}}</h2>
                                </div>
                            </div>
                            <div class="box-body with-border">
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>TIPO COMPROBANTE</label>
                                            <select class="form-control" v-model="tipo_comprobante" @change="generarNumerosComprobante(tipo_comprobante)">
                                                <option value="BOLETA">BOLETA</option>
                                                <option value="FACTURA">FACTURA</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">SERIE COMPROBANTE</label>
                                            <input type="text" class="form-control" disabled v-model="serie_comprobante">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">NUMERO COMPROBANTE</label>
                                            <input type="text" class="form-control" disabled v-model="numero_comprobante">
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>CLIENTE</label>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary" @click="opcionModalCLiente = 1" data-toggle="modal" data-target="#modalCliente" title="Nuevo Cliente"><i class="fa fa-user-plus"></i></button>
                                                </span>
                                                <!-- <span class="input-group-addon" style="width:0px; padding-left:0px; padding-right:0px; border:none;"></span> -->
                                                <select class="form-control col-md-3 select2"  style="width: 100%;" id="idcliente"  v-if="tipo_comprobante =='BOLETA' ">
                                                    <option v-for="proveedor in filtrarClientes"  :key="proveedor.id" :value="proveedor.id" v-text="proveedor.num_documento +' - '+ proveedor.nombre" ></option>
                                                </select>

                                                <select class="form-control col-md-3 select2"  style="width: 100%;" id="idcliente" v-else>
                                                    <option  v-for="proveedor in filtrarClientes"  :key="proveedor.id" :value="proveedor.id" v-text="proveedor.num_documento +' - '+ proveedor.razon_social"></option>
                                                </select>
                                            </div>
                                          
                                            <ModalCliente :enlace="enlace" v-if="opcionModalCLiente" :opcion="0" /> 
                                           
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="box-footer with-border">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>SUB TOTAL</th> 
                                            <td v-text="(calcularSubtotal).toFixed(2)"></td>
                                        </tr> 
                                    </thead>
                                    <thead>
                                        <tr>
                                            <th>IGV</th> 
                                            <td v-text="(calcularIgv).toFixed(2)"></td>
                                        </tr>  
                                    </thead>
                                    <thead>
                                        <tr>
                                            <th>TOTAL</th> 
                                            <td v-text="(calcularTotal).toFixed(2)"></td>
                                        </tr>
                                    </thead>

                                </table>

                                <div class="form-group">
                                    <button class="btn btn-primary  pull-right" @click="registrarVenta()"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;Registrar Venta</button>
                                    <button type="button" class="btn btn-success pull-left" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i>&nbsp;&nbsp;Volver a la venta</button>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- MODAL PRODUCTO -->

        <div class="modal fade" id="modalProducto">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header modales">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Lista de Productos</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" id="tableVenta">
                                                <thead>
                                                    <tr>
                                                    <th>Agregar</th>
                                                        <th>Imágen</th>
                                                        <th>Código</th>
                                                        <th>U. Medida</th>
                                                        <th>Descripción</th>
                                                        <th>Categoría</th>
                                                        <th>Precio</th>
                                                        <th>Stock</th>
                                                    </tr>
                                                    </thead>
                                                <tbody>
                                                    <tr v-for="producto in productos" :key="producto.id">
                                                        <td>
                                                            <button type="button" class="btn btn-success" @click="agregarDetalleModal(producto)"><i class="fa fa-plus"></i></button>
                                                        </td>
                                                        <td><img width="50" height="50" :src="producto.ruta"></td>
                                                        <td v-text="producto.codigo"></td>
                                                        <td v-text="producto.unidad_medida"></td>
                                                        <td v-text="producto.descripcion"></td>
                                                        <td v-text="producto.categoria"></td>
                                                        <td v-text="producto.precio_venta"></td>
                                                        <td>
                                                            <button type="button" :class="producto.stock >= 10 ? 'btn btn-primary':'btn btn-danger' " v-text="producto.stock"></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="box-footer">
                                <button type="button" class="btn btn-secondary"  data-dismiss="modal" aria-label="Close">Cerrar</button>
                            </div>
                        </form>      
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modal-comprobante">
            <div class="modal-dialog  modal-sm">
                <div class="modal-content">
                    <div class="modal-header modales">
                        <h4 class="modal-title">Tipo de impresiones</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form">
                            <div class="box-body">
                                <div class="row">
                                    <table class="table text-center">
                                        <thead>
                                            <tr>
                                                <th>Imprimir A4</th>
                                                <th>Imprimir Ticket</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <button type="button" @click="pdfVenta()" class="btn btn-info btn-lg"><i class="fa fa-print"></i></button>
                                                </td>
                                                <td>
                                                    <button type="button" @click="ticket()" class="btn btn-default btn-lg" title="Enviar correo"><i class="fa fa-envelope"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                            <div class="box-footer">
                                <button type="button" class="btn btn-secondary"  data-dismiss="modal" aria-label="Close">Cerrar</button>
                            </div>
                        </form>      
                    </div>
                </div>
            </div>
        </div>



    </div>
   
</template>

<script>
import {mapState,mapActions} from 'vuex'
import ModalCliente from './ModalCliente.vue';
export default {
    props:['enlace'],
    components: {ModalCliente},
    data(){
        return{
            productos:[],
            arrayDetalle:[],

            tipo_comprobante:'BOLETA',
            serie_comprobante:'',
            numero_comprobante:'',
            numero_generador_comprobante:'',

            codigo: '',
            idproducto:0,
            descripcion:'',
            precio:0.00,
            precio_compra: 0.00,
            unidad_medida:'',
            cantidad:0,
            stock:'',

            opcionModalCLiente: 0
        }
    },

    computed:{

        calcularSubtotal(){
            let me = this;
            let resultado = 0.00;
            for (let index = 0; index < me.arrayDetalle.length; index++) {
                resultado = Number(resultado + (Number(me.arrayDetalle[index].precio * me.arrayDetalle[index].cantidad))/1.18);
            }
            return resultado;
        },

        calcularIgv(){
            let me = this;
            let resultado = 0.00;
            for (let index = 0; index < me.arrayDetalle.length; index++) {
                resultado = Number(resultado + (Number(me.arrayDetalle[index].precio * me.arrayDetalle[index].cantidad))/1.18 * 0.18);
                
            }
            return resultado;
        },

        calcularTotal(){
            let me = this;
            let resultado = 0.00;
            for (let index = 0; index < me.arrayDetalle.length; index++) {
                resultado = Number(resultado + (me.arrayDetalle[index].precio * me.arrayDetalle[index].cantidad));
            }
            return resultado;
        },

        calcularCreditoFiscal(){
            let me = this , resultado = 0.00, sub_total_precio_compra = 0.00;
        
            for (let index = 0; index < me.arrayDetalle.length; index++) {
                 sub_total_precio_compra = Number(sub_total_precio_compra + (me.arrayDetalle[index].precio_compra * me.arrayDetalle[index].cantidad) /1.18);
            }
            resultado = (me.calcularSubtotal * 0.18) - (sub_total_precio_compra * 0.18)
            return (resultado).toFixed(2);
        },

        ...mapState(['clientes']),

        filtrarClientes:function(){
            let tipo_documento = '';
            let me = this;
            if (me.clientes.length) {
                $('.select2').select2()
            }
            if (me.tipo_comprobante == 'BOLETA') {

                return this.clientes.filter(i => i.tipo_documento != 'RUC')
            }else {

                return this.clientes.filter(i => i.tipo_documento === 'RUC')
            }
        
        },
    },
    
    methods:{

        listarProducto() {
            let me = this;
              const url = me.enlace+'/producto/buscarProductoVenta';
            axios.get(url).then((res) => {
                me.productos = res.data.productos;
            });
        },

        ...mapActions(['listarCliente']),

        
        listarClientes(){
            if (!this.clientes.length) {
                this.listarCliente();
            }
        },

        encuentra(id){
            var sw=0;
            for(var i=0;i<this.arrayDetalle.length;i++){
                if(this.arrayDetalle[i].idproducto == id){
                    sw=true;
                }
            }
            return sw;
        },

        eliminarItem(index){    
            this.arrayDetalle.splice(index,1);
        },

        buscarProducto(){
            let me = this;
            let arrayProductos =[];
            const url = me.enlace+'/producto/buscarProductoVenta?filtro='+me.codigo;
            axios.get(url).then(function(res){
                
                arrayProductos = res.data.productos;
                
                if (arrayProductos.length > 0 && me.codigo !='') {

                    me.idproducto = arrayProductos[0]['id'];
                    me.descripcion = arrayProductos[0]['descripcion'];
                    me.precio = arrayProductos[0]['precio_venta'];
                    me.precio_compra = arrayProductos[0]['precio_compra'];
                    me.unidad_medida = arrayProductos[0]['unidad_medida'];
                    me.stock = arrayProductos[0]['stock'];
                    me.cantidad = 1;
                }else if( me.codigo ==''){
                    me.descripcion='';
                }else{
                    me.descripcion='No existe producto';
                    me.idproducto=0;
                    me.cantidad = 0;
                    me.precio = 0.00;
                    me.unidad_medida = '';
                }
            })
        },
        
        agregarDetalle(){
            let me = this;
            if(me.idproducto == 0  || me.precio == 0 || me.cantidad ==  0){
            } 
            else{

                    if(me.encuentra(me.idproducto)){
                    swal({
                        type: 'error',
                        title: 'Error...',
                        text: 'Ese artículo ya se encuentra agregado!',
                        })
                }else{
                    me.arrayDetalle.push({
                    idproducto: me.idproducto,
                    descripcion: me.descripcion,
                    precio:me.precio,
                    precio_compra: me.precio_compra,
                    unidad_medida: me.unidad_medida,
                    cantidad: me.cantidad,
                    stock: me.stock

                    });
                    me.idproducto = 0;
                    me.descripcion = '';
                    me.precio = 0.00;
                    me.precio_compra = 0.00;
                    me.unidad_medida = '';
                    me.cantidad = 0;
                    me.codigo = "";
            
                }
            }
        },

        agregarDetalleModal(data){
            let me = this;

            if(me.encuentra(data['id'])){
                swal({
                    type: 'error',
                    title: 'Error...',
                    text: 'Ese artículo ya se encuentra agregado!',
                });
            }else{
                swal({
                    position: 'center',
                    type: 'success',
                    title: data.descripcion,
                    showConfirmButton: false,
                    timer: 1300
                });
                me.arrayDetalle.push({
                idproducto:     data['id'],
                descripcion:    data['descripcion'],
                precio: data['precio_venta'],
                precio_compra: data['precio_compra'],
                unidad_medida: data['unidad_medida'],
                stock: data['stock'],
                cantidad: 1
                });
            }

        },

        cantidadDetalle:function(opcion,data = []){
           
            let me = this;
            if (data.stock <= data.cantidad) {
                swal({
                    title: "La cantidad supera el Stock",
                    text: "¡Sólo hay "+data.stock+" unidades!",
                    type: "error",
                    confirmButtonText: "¡Cerrar!"
                });
                data.cantidad = 0;
            }else{

                if(opcion == '+'){
                    
                    data.cantidad ++;
                }else{

                    if(data.cantidad <= 1){
                        return
                    }else{
                        data.cantidad --;
                    }

                }
            }
        
        },

        cantidadPrincipal:function(opcion){
            let me = this;
            if(opcion == '+'){
                
               me.cantidad ++;
            }else{

                if(me.cantidad <= 1){
                    return
                }else{
                    me.cantidad --;
                }

            }
        },

        myTable(){
            $(document).ready( function () {
                $("#tableVenta").DataTable({

                    "deferRender": true,
                    "retrieve": true,
                    "processing": true,
                    "language": {

                            "sProcessing":     "Procesando...",
                            "sLengthMenu":     "Mostrar _MENU_ registros",
                            "sZeroRecords":    "No se encontraron resultados",
                            "sEmptyTable":     "Ningún dato disponible en esta tabla",
                            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
                            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
                            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix":    "",
                            "sSearch":         "Buscar:",
                            "sUrl":            "",
                            "sInfoThousands":  ",",
                            "sLoadingRecords": "Cargando...",
                            "oPaginate": {
                            "sFirst":    "Primero",
                            "sLast":     "Último",
                            "sNext":     "Siguiente",
                            "sPrevious": "Anterior"
                            },
                            "oAria": {
                                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                            }
                    }

                });
            });
        },

        generarNumeroComprobante(numero){
            let num = '';
            if ( numero == null ||  numero == 0 ) {
                numero = 1;
            } else{
                if (numero < 10 ){
                    num = "00000000"+ numero;
                }else if (numero < 100 ){
                    num = "0000000"+ numero;
                }else if (numero < 1000){
                    num = "000000"+ numero;
                }else if(numero < 100000){
                    num = "00000"+ numero;
                }else if(numero < 1000000){
                    num = "0000"+ numero;
                }else if(numero < 10000000){
                    num = "000"+ numero;
                }else if(numero < 100000000){
                    num = "00"+ numero;
                }
            }
            return num;
        },

        generarSerieComprobante(tipo){
            let num = '';
            if(tipo){
                if(tipo == 'BOLETA'){
                    num= 'B001';
                }else{
                    num = 'F001'
                }
            }
            return num;
        },

        generarNumerosComprobante(tipo){
            let me = this;
            let numero = 0;
            const url = me.enlace + '/venta/numero?tipo='+tipo;
            axios.get(url).then((res)=>{
                numero = res.data.numero[0]['id'] + 1;
                me.serie_comprobante = me.generarSerieComprobante(tipo);
                me.numero_comprobante = me.generarNumeroComprobante(numero);
            });

        },

        validarVenta(){
            let me = this;
            for (let index = 0; index < me.arrayDetalle.length; index++) {
                if (me.arrayDetalle[index].cantidad > me.arrayDetalle[index].stock){
                     return true
                }
                if (me.arrayDetalle[index].cantidad <= 0){
                     return true
                 }
                  
            }
        },

        registrarVenta(){

            let me = this;
            if (me.validarVenta()) {
                return
            }
            
            swal({
                title: 'Está seguro de registrar la venta?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    const url = me.enlace+'/venta';
                            
                    axios.post(url,{
                        'idcliente': $("#idcliente").val(),
                        'tipo_comprobante': me.tipo_comprobante,
                        'serie_comprobante' : me.serie_comprobante,
                        'numero_comprobante' : me.numero_comprobante,
                        'credito_fiscal' : me.calcularCreditoFiscal,
                        'total':me.calcularTotal,
                        'data': me.arrayDetalle
                    }).then((res) => {
                        swal({
                        type: 'success',
                        title: 'Éxito...',
                        text: 'Compra registrada con éxito!',
                        })
                        me.tipo_comprobante='BOLETA';
                        me.serie_comprobante='';
                        me.numero_comprobante='';
                        me.arrayDetalle = [];
                        $("[data-dismiss=modal]").trigger({ type: "click" });
                        $('#modal-comprobante').modal('show'); 
                        $('#tableVenta').DataTable().destroy();
                        me.listarProducto();
                        me.generarNumerosComprobante('BOLETA');
                    });
            }});

        },

        pdfVenta(){
            let me = this;
            let url = me.enlace+'/venta/ventaid';
            let id = 0;
            axios.get(url).then((res) =>{
                id = res.data
                window.open(me.enlace + '/venta/listarPdfVenta?id='+ id );
            })

        },

        ticket(){
            let me = this;
            let url = me.enlace+'/venta/ventaid';
            let id = 0;
            axios.get(url).then((res) =>{
                id = res.data
                window.open(this.enlace + '/venta/ticket/'+ id + ',' + '_blank');
            })

        },
  
    },

    created(){
        this.generarNumerosComprobante('BOLETA');
    },

    mounted(){
        this.listarProducto();
        // this.listarCliente();
    }
}
</script>

<style scoped>

    .div-total{
        background: red;
        padding: 2px;
        margin: 0px;
        color: #fff;
    }

    @media (min-width: 600px) {
        .btnagregar {
            margin-top: 2rem;
        }

    }

    @media (max-width: 600px) {

        .personalizado {
            width: auto;
        }
     }

    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none; 
    margin: 0; 
    }

    .hijo{
        padding: 0;
        margin-left: -10px;
    }

    .cabecera{
         background: #4875CA;
        color: #fff;
    }
</style>