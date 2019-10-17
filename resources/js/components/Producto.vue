<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-header">
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-primary" @click="abrirModal('registrar', '')"  data-toggle="modal" data-target="#modal-producto" data-backdrop="static" data-keyboard="false"><i class="fa fa-plus"></i>&nbsp;&nbsp;Nuevo</button>&nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-success" @click="cargarPdf()"><i class="fa fa-print"></i>&nbsp;&nbsp;PDF</button>
                        </div>
                    </div>
                </div>
                <hr>

                <div class="box-body table-responsive">
                    <table class="table table-hover table-striped" id="tablaProducto">
                        <thead>
                            <tr>
                                <th>Opciónes</th>
                                <th>Código</th>
                                <th>Imágen</th>
                                <th>Categoría</th>
                                <th>Producto</th>
                                <th>P. Compra</th>
                                <th>P. Venta</th>
                                <th>Stock</th>
                                <th>U. Medida</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="producto in filtarProductos" :key="producto.id">
                                <td>
                                    <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal-producto" data-backdrop="static" data-keyboard="false" @click="abrirModal('editar',producto)"><i class="fa fa-pencil"></i></button>&nbsp;&nbsp;
                                    <button type="button" class="btn btn-danger btn-xs" @click="updProducto(producto)" v-show="producto.estado"><i class="fa fa-trash"></i></button>&nbsp;&nbsp;
                                    <button type="button" class="btn btn-success btn-xs" @click="updProducto(producto)" v-show="producto.estado !=1"><i class="fa fa-check"></i></button>
                                </td>
                                <td v-text="producto.codigo"></td>
                                <td>
                                    <img class="img-thumbnail" :src="producto.ruta" width="60" height="60">
                                </td>
                                <td v-text="producto.categoria"></td>
                                <td v-text="producto.descripcion"></td>
                                <td v-text="producto.precio_compra"></td>
                                <td v-text="producto.precio_venta"></td>
                                <td v-text="producto.stock"></td>
                                <td v-text="producto.unidad_medida"></td> 
                                <td><span v-text="producto.estado?'Acitvo':'Desactivado'" :class="producto.estado?'label label-primary':'label label-danger'"></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-producto">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modales">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                    </div>
                    <div class="modal-body">

                        <form class="form" enctype="multipart/form-data">
                            <div class="box-body">

                                <div class="form-group">
                                    <label for="">CATEGORIA</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                                        <select class="form-control input-lg" v-model="idcategoria">
                                            <option value="0" disabled>Seleccionar categoría</option>
                                            <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id"
                                                v-text="categoria.nombre"></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="">CODIGO DE PRODUCTO</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-code"></i></span> 
                                        <input type="text" class="form-control input-lg"  v-model="codigo" maxlength="20" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default btn-lg" title="Generar código" type="button" @click="codigoAleatorio(1,1)"><i class="fa fa-random"></i></button>
                                        </span>
                                    </div>
                                    <span>Se puede escanear su código de barras y escáner también</span>
                                    <span style="color:red;"  v-show="encontrarCodigo.length">   (Esté código ya está asiganado) </span>
                                </div>

                           
                                <div class="form-group">
                                    <label for="">DESCRIPCION DEL PRODUCTO</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-check"></i></span> 
                                        <input type="text" class="form-control input-lg" v-model="descripcion" @input="descripcion = $event.target.value.toUpperCase()">
                                        <span class="input-group-addon" style="width:0px; padding-left:0px; padding-right:0px; border:none;"></span>
                                        <select class="form-control input-lg col-md-3" v-model="unidad_medida">
                                            <option value="Und">Und</option>
                                            <option value="Kg">Kg</option>
                                            <option value="Gr">Gr</option>
                                            <option value="Lt">Lt</option>
                                            <option value="m">m</option>
                                        </select>
                                     </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-xs-6">
                                        <label for="">PRECIO DE COMPRA</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 
                                            <input type="number" class="form-control input-lg" v-model="precio_compra">
                                        </div>
                                    </div>

                                    <div class="col-xs-6">
                                        <label for="">PRECIO DE VENTA POR </label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 
                                            <input type="number" class="form-control input-lg" v-model="precio_venta">
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="">STOCK</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-check"></i></span> 
                                        <input type="number" class="form-control input-lg" v-model="stock">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-camera"></i></span> 
                                        <input type="file" class="form-control" ref="file" @change="onUploadImagen($event)">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-4">
                                        <img :src="img" height="150px" width="150px" class="img-thumbnail">
                                    </div>
                                </div>
  
                                <div v-show="errorProducto" class="form-group row div-error">
                                    <div class="col-lg-12">
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <ul>
                                                <li  v-for="error in errorMostrarMsjProducto" :key="error" v-text="error"></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary pull-right" v-if="opcionModal" @click="registrar()">Registrar</button>
                        <button type="submit" class="btn btn-primary pull-right" v-else @click="editar()">Editar</button>
                    </div>
                </div>
            </div>
        </div>                      
    </div>
    

</template>

<script>

    export default {
        props: ['enlace'],
        data() {
            return {
                productos: [],
                categorias: [],
                id: '',
                codigo: '',
                descripcion: '',
                idcategoria: 0,
                unidad_medida: 'Und',
                stock: '',
                precio_compra:'',
                precio_venta:'',
                ruta: null,
                img: 'thumbnail/default/anonymous.png',
                imagenActual: null,
                opcionModal: 1,
                tituloModal: '',
                buscarProducto: '',


                errorProducto: 0,
                errorMostrarMsjProducto: [],

                // arrayTipoEnvase: [ "SACO","PAQUETE","CAJA","GALON","BARRIL","JAVA","LATA","BIDON","BOLSA","BALON","BANDEJA","BOTELLA","FRASCO","BOTE","OTROS"]
            }
        },


     
        computed:{

            filtarProductos:function(){
                let me = this;
                return me.productos.filter(producto => {
                    return producto.descripcion.includes((me.buscarProducto).toUpperCase());
                });
            },

            encontrarCodigo(){
                let me = this;
                return  me.filtarProductos.filter(i => i.codigo === me.codigo);
            }
        },
      

        methods: {

            listarProducto() {
                let me = this;
                let url = me.enlace+'/producto';
                axios.get(url).then((res) => {
                    me.productos = res.data.producto;
                    if (me.productos.length) {
                        me.myTable();
                    }
                });
            },

            listarCategorias() {
                let me = this;
                let url = me.enlace+'/categoria/cbo';
                axios.get(url).then((res) => {
                    me.categorias = res.data.categoria;
                })
            },

            validarProducto(){

                let me = this;
                me.errorProducto=0;
                me.errorMostrarMsjProducto =[];
                $(".alert-danger").fadeTo(2000, 3000).slideUp(3000, function(){
                    $(".alert-danger").slideUp(3000);
                });

                if (me.idcategoria==0) me.errorMostrarMsjProducto.push("Seleccione una categoría.");
                if (!me.codigo) me.errorMostrarMsjProducto.push("El código del producto no puede estar vacío.");
                if (!me.descripcion) me.errorMostrarMsjProducto.push("La descripción del producto no puede estar vacío.");
                if (me.stock < 0) me.errorMostrarMsjProducto.push("El stock del producto debe ser un número positivo.");
                if (!me.precio_compra) me.errorMostrarMsjProducto.push("El precio compra del producto debe ser un número y no puede estar vacío.");
                if (!me.precio_venta) me.errorMostrarMsjProducto.push("El precio venta del producto debe ser un número y no puede estar vacío.");

                if (me.errorMostrarMsjProducto.length) me.errorProducto = 1;

                return me.errorProducto;
            },

            registrar() {
                let me = this;

                if (this.validarProducto()){
                    return;
                }
                swal({
                    title: 'Está seguro de registrar este producto?',
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
                                
                        const formData = new FormData()
                        formData.append('idcategoria', me.idcategoria);
                        formData.append('codigo', me.codigo);
                        formData.append('descripcion', me.descripcion);
                        formData.append('unidad_medida', me.unidad_medida);
                        formData.append('precio_compra', me.precio_compra);
                        formData.append('precio_venta', me.precio_venta);
                        formData.append('stock', me.stock);
                        formData.append('ruta', me.ruta);

                        const url = me.enlace+'/producto';

                        axios.post(url, formData).then((res) => {
                            $("[data-dismiss=modal]").trigger({ type: "click" });
                            $('#tablaProducto').DataTable().destroy();
                            this.listarProducto();
                    });
                }});
              
            },

            editar() {

                let me = this;
                if (this.validarProducto()){
                    return;
                }
                swal({
                    title: 'Está seguro de editar este producto?',
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
                        const formData = new FormData()
                        formData.append('id', me.id);
                        formData.append('idcategoria', me.idcategoria);
                        formData.append('codigo', me.codigo);
                        formData.append('descripcion', me.descripcion);
                        formData.append('unidad_medida', me.unidad_medida);
                        formData.append('imagenActual', me.imagenActual);
                        formData.append('ruta', me.ruta);
                        formData.append('stock', me.stock);
                        formData.append('precio_compra', me.precio_compra);
                        formData.append('precio_venta', me.precio_venta);
                        
                        let url = me.enlace+'/producto/editar';

                        axios.post(url, formData).then((res) => {
                            $("[data-dismiss=modal]").trigger({ type: "click" });
                            $('#tablaProducto').DataTable().destroy();
                            me.listarProducto();
                        });
                }});
            },

            onUploadImagen(e) {
                let me = this;
                me.ruta = this.$refs.file.files[0];
                let fileReader = new FileReader();
                fileReader.readAsDataURL(e.target.files[0]);

                fileReader.onload = (e) => {
                    me.img = e.target.result
                }
            },

            abrirModal(accion, data = []) {
                let me = this;
                if (accion == 'registrar') {

                    me.codigo = '';
                    me.descripcion = '';
                    me.idcategoria = 0;
                    me.unidad_medida = 'Und';
                    me.stock = '';
                    me.precio_compra = '';
                    me.precio_venta = '';
                    me.ruta = null;
                    me.img = 'thumbnail/default/anonymous.png';
                    me.opcionModal = 1;
                    me.tituloModal = "Registrar Producto";
                    me.listarCategorias();
                } else {
                    me.codigo = data.codigo;
                    me.descripcion = data.descripcion;
                    me.idcategoria = data.idcategoria;
                    me.unidad_medida = data.unidad_medida;
                    me.stock = data.stock;
                    me.ruta = data.ruta;
                    me.precio_compra = data.precio_compra;
                    me.precio_venta = data.precio_venta;
                    me.img = data.ruta;
                    me.imagenActual = data.ruta;
                    me.ruta = data.ruta
                    me.id = data.id;
                    me.opcionModal = 0;
                    me.tituloModal = "Editar Producto";
                }
            },

            updProducto(data){  
                let me = this;
                const url = (me.enlace+'/producto/estado');
                axios.put(url,data).then(function(response) {
                    swal({
                        type: "success",
                        title: "Éxito...",
                        text: "Estado actualizado!"
                    });
                    $('#tablaProducto').DataTable().destroy();
                        me.listarProducto()
                });
            
            },

            myTable(){
               this.$nextTick(() =>{
                    $("#tablaProducto").DataTable({

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
                })
            },


            codigoAleatorio(min, max) {
               
                return this.codigo = Math.round( Math.random() * 100000000) ;
            },

            
            cargarPdf(){
                window.open(this.enlace + '/producto/listarPdf','_blank');
            },
        },


        mounted() {
            this.listarProducto();
            this.listarCategorias();
        }
    }
</script>