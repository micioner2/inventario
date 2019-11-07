<template>
    <div class="row">
        <!--TABLA INGRESO -->
        <div class="col-lg-8 col-xs-12">
            <div class="box box-primary">
                <div class="box box-default">
                    <div class="box-header with-border text-center">
                        <h3 class="box-title" style="color:blue;">Compras</h3>
                    </div>

                    <div class="box-body with-border">
                        <div class="row">
                            <div class="col">
                                <div class="hidden-sm hidden-xs">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>PRODUCTO</label>
                                            <div class="form-inline">
                                                <input style="width:80%" type="text" class="form-control" placeholder="Ingrese codigo" v-model="codigo" @keyup.enter="buscarProducto()" maxlength="6" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalProducto" data-backdrop="static" data-keyboard="false" @click="myTable()"><i class="fa fa-search"></i></button>
                                                <input style="width:80%; font-weight:bold;" type="text" readonly class="form-control" v-model="descripcion">
                                            </div>                                    
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
                                            <input type="number" value="0" class="form-control" v-model="cantidad">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-success form-control btnagregar" @click="agregarDetalle()"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                    
                                <div class="col-md-12 hidden-md hidden-lg">
                                    <div class="form-group">
                                        <button type="button" @click="myTable()" class="btn btn-primary" data-toggle="modal" data-target="#modalProducto"><i class="fa fa-search"></i>&nbsp;&nbsp;Listar Productos</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table table-responsive" v-if="arrayDetalle.length">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>OPCION</th>
                                        <th>CANT.</th>
                                        <th style="width:40%">PRODUCTO</th>
                                        <th>PRECIO</th>
                                        <th>IMPORTE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item,index) in arrayDetalle" :key="index">
                                        <td>
                                            <button type="button" @click="eliminarItem(index)" class="btn btn-danger"><i class="fa fa-times"></i></button>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button  class="btn btn-primary" type="button" @click="cantidadDetalle('-',item)"><i class="fa fa-minus"></i></button>
                                                </span>
                                                    <input type="number" class="form-control text-center alargar" min="1" value="1" v-model.number="item.cantidad">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary" type="button"  @click="cantidadDetalle('+',item)"><i class="fa fa-plus"></i></button>
                                                </span>
                                            </div>
                                        </td>
                                        <td v-text="item.descripcion"></td>
                                        <td>
                                            <span style="color:red;"  v-show="item.precio <= 0 ">Precio > 0</span>
                                            <input type="number" class="form-control alargar" v-model="item.precio">
                                        </td>
                                        <td class="alargar" v-text="(item.precio * item.cantidad).toFixed(2)"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="box-footer with-border">
                        <button v-if="arrayDetalle.length" class="btn btn-info pull-left" @click="registrarIngreso()"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;Registrar Compra</button>                  
                    </div>
                </div>
            </div>
        </div>

        <!--DETALLE INGRESO -->
        <div class="col-lg-4 hidden-md hidden-sm hidden-xs">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="box-header with-border">
                        <div class="div-total">
                            <h2 class="text-center">S/ {{(calcularTotal).toFixed(2)}}</h2>
                        </div>
                    </div>
                    <div class="box-body with-border">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>TIPO COMPROBANTE</label>
                                    <select class="form-control input-lg" v-model="tipo_comprobante">
                                        <option value="FACTURA">FACTURA</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">S. COMPROBANTE</label>
                                    <input type="text" class="form-control input-lg" v-model="serie_comprobante" placeholder="0001">
                                </div>
                            </div>

                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="">N. COMPROBANTE</label>
                                    <input type="text" class="form-control input-lg"  v-model="numero_comprobante" placeholder="00000001">
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>PROVEEDOR</label>
                                    <select class="form-control select2" style="width: 100%;" id="idpersona">
                                        <option  v-for="proveedor in filtrarProveedores" :key="proveedor.id" :value="proveedor.id" v-text="proveedor.num_documento +' - '+ proveedor.razon_social"></option>
                                    </select>
                                    <ModalProveedor :enlace="enlace"  v-if="opcionModalCLiente" /> 
                                    <button class="btn btn-primary btn-xs pull-left" @click="opcionModalCLiente = 1" data-toggle="modal" data-target="#modalCliente" title="Nuevo Cliente"><i class="fa fa-user-plus"></i></button>
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
                    </div>

                </div>
            </div>
        </div>


        <!-- MODAL PRODUCTO -->

        <div class="modal  fade" id="modalProducto">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Productos</h4>
                    </div>
                        <div class="modal-body">
                            <form class="form">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped tablas">
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
                                                            <td v-text="producto.precio_compra"></td>
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

    </div>
   
</template>

<script>

import {mapState,mapActions} from 'vuex'
import ModalProveedor from './ModalProveedor';

export default {
    props:['enlace'],
    components: {ModalProveedor},
    data(){
        return{
            productos:[],
            arrayDetalle:[],

            tipo_comprobante:'FACTURA',
            serie_comprobante:'',
            numero_comprobante:'',
            numero_generador_comprobante:'',

            codigo: '',
            idproducto:0,
            descripcion:'',
            precio:0.00,
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

         filtrarProveedores:function(){
            let me = this;
            if (me.proveedores.length) {
                $('.select2').select2()
            }
             return this.proveedores.filter(i => i.tipo_documento != 'DNI')
        },

        ...mapState(['proveedores']),


    },
    methods:{

        listarProducto() {
            let me = this;
            const url = me.enlace+'/producto';
            axios.get(url).then((res) => {
                me.productos = res.data.producto;
            });
        },

        ...mapActions(['listarProveedor']),

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
            const url = me.enlace+'/producto/buscarProductoIngreso?filtro='+me.codigo;
            axios.get(url).then(function(res){
                
                arrayProductos = res.data.productos;
                
                if (arrayProductos.length > 0 && me.codigo !='') {

                    me.idproducto = arrayProductos[0]['id'];
                    me.descripcion = arrayProductos[0]['descripcion'];
                    me.precio = arrayProductos[0]['precio_compra'];
                    me.stock = arrayProductos[0]['stock'];
                    me.cantidad = 1;
                }else{
                    me.descripcion='No existe producto';
                    me.idproducto=0;
                    me.cantidad = 0;
                    me.precio = 0.00;
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
                    cantidad: me.cantidad,
                    stock: me.stock

                    });
                    me.idproducto = 0;
                    me.descripcion = '';
                    me.precio = 0.00;
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
                precio: data['precio_compra'],
                cantidad: 1
                });
            }

        },

        cantidadDetalle:function(opcion,data = []){
            let me = this;
            if(opcion == '+'){
                
                data.cantidad ++;
            }else{

                if(data.cantidad <= 1){
                    return
                }else{
                    data.cantidad --;
                }
            }
        },

        myTable(){
            $(document).ready( function () {
                $(".tablas").DataTable({

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

        registrarIngreso(){

            swal({
                title: 'Está seguro de registrar la compra?',
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
                    let me = this;
                    const url = me.enlace+'/ingreso';
                            
                    axios.post(url,{
                        'idpersona': $("#idpersona").val(),
                        'tipo_comprobante': me.tipo_comprobante,
                        'serie_comprobante': me.serie_comprobante,
                        'numero_comprobante' : me.numero_comprobante,
                        'total':me.calcularTotal,
                        'data': me.arrayDetalle
                    }).then((res) => {

                        swal({
                        type: 'success',
                        title: 'Éxito...',
                        text: 'Compra registrada con éxito!',
                        })
                        me.tipo_comprobante='FACTURA';
                        me.arrayDetalle = [];
                        me.listarProducto();
                        me.generarNumerosComprobante('FACTURA');
                    });
            }});

        },


    },

    mounted(){
        this.listarProducto();
        this.listarProveedor();
    }
}
</script>

<style>


    .div-total{
        background: #306CA4;
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
        .alargar {
            width: auto;
        }
     }

    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none; 
    margin: 0; 
    }
</style>