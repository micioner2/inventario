<template>
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-align-justify"></i>Proveedor &nbsp; &nbsp;
            <button class="btn btn-primary" @click="abrirModal('registrar','')" data-toggle="modal" data-target="#modalCliente" data-backdrop="static" data-keyboard="false"><i class="fa fa-plus"></i>&nbsp;&nbsp;Nuevo</button>
        </div>
        <div class="box-body table-responsive">

            <table class="table table-hover table-striped" id="tablaCliente">
                <thead>
                    <tr>
                        <th>Opciones</th>
                        <th>Tipo Documento</th>
                        <th>Número</th>
                        <th>Razón Social</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="cliente in filtrarCliente" :key="cliente.id" >
                        <td>
                            <button class="btn btn-primary btn-xs" @click="abrirModal('',cliente)"  data-toggle="modal" data-target="#modalCliente" data-backdrop="static" data-keyboard="false"><i class="fa fa-pencil"></i></button>&nbsp;&nbsp;
                            <button class="btn btn-danger btn-xs" @click="actualizarCliente(cliente)" v-if="cliente.estado"><i class="fa fa-trash"></i></button> 
                                <button class="btn btn-success btn-xs" @click="actualizarCliente(cliente)" v-else><i class="fa fa-check"></i></button> 
                        </td>
                        <td v-text="cliente.tipo_documento"></td>
                        <td v-text="cliente.num_documento"></td>
                        <td v-text="cliente.razon_social"></td>
                        <td v-text="cliente.direccion"></td>
                        <td v-text="cliente.telefono"></td>
                        <td v-text="cliente.correo"></td>
                        <td><span v-text="cliente.estado?'Acitvo':'Desactivado'" :class="cliente.estado?'label label-primary':'label label-danger'"></span></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="modal fade" id="modalCliente" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                    </div>
                        <div class="modal-body">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >Tipo Doc. Identidad  </label>
                                    <select  class="form-control" v-model="cliente.tipo_documento" :disabled="!opcionModal">
                                        <option value="RUC">RUC</option>
                                    </select>                    
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Numero<span style="color:red;" v-if="opcionModal" v-show="encontrarCliente.length">    (Cliente ya existe) </span></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" :disabled="!opcionModal"  v-model="cliente.num_documento"  maxlength="11" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" @keyup.enter="traerNombre()">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" @click="traerNombre()"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12" v-show="cliente.tipo_documento=='DNI'">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" class="form-control" v-model="cliente.nombre"   @input="cliente.nombre = $event.target.value.toUpperCase()">
                                </div>
                            </div>

                            <div class="col-md-12" v-show="cliente.tipo_documento=='RUC'">
                                <div class="form-group">
                                    <label>Razón Social</label>
                                    <input type="text" class="form-control" v-model="cliente.razon_social"  @input="cliente.razon_social = $event.target.value.toUpperCase()">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Correo</label>
                                    <input type="text" class="form-control" v-model="cliente.correo">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Teléfono</label>
                                    <input type="text" class="form-control" v-model="cliente.telefono">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Dirección</label>
                                    <input type="text" class="form-control" v-model="cliente.direccion"  @input="cliente.direccion = $event.target.value.toUpperCase()">
                                </div>
                            </div>

                            <div v-show="errorCliente" class="form-group row div-error">
                                <div class="col-lg-12">
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <ul>
                                            <li v-for="error in errorMostrarMsjCliente" :key="error" v-text="error"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                  
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary pull-right" v-if="opcionModal" @click="registrarProveedor()">Registrar</button>
                            <button type="submit" class="btn btn-primary pull-right" v-else @click="editarCliente()">Editar</button>
                        </div>
                </div>
            </div>
        </div>
                
    </div>      

</template>

<script>

export default {
    props: ['enlace'],

    data(){
        return{
            clientes:[],
            inputCliente:'',

            cliente: {
                tipo_persona:'Proveedor',
                id:0,
                tipo_documento:'RUC',
                num_documento:'',
                nombre:'',
                razon_social:'',
                correo: '',
                telefono:'',
                direccion:'',
            },
            tituloModal:'',
            opcionModal: 1,
            errorCliente: 0,
            errorMostrarMsjCliente: []
        }
    },

    computed:{

        filtrarCliente(){
            let me = this;
            return me.clientes.filter(cliente => {
                return  cliente.num_documento;
            });
        },

        encontrarCliente(){
            let me = this;
            return  me.filtrarCliente.filter(i => i.num_documento === me.cliente.num_documento);
        }
    },

    methods:{

        listarCliente(){
            let me = this;
                let url = me.enlace+'/persona/proveedor';
            axios.get(url).then((res) => {
                me.clientes = res.data.proveedor;
                if (me.clientes.length) {
                    me.myTable();
                }
            });
        },


        abrirModal(accion, data = []) {
            let me = this;
            if (accion == 'registrar') {
                me.cliente.nombre = "";
                me.cliente.tipo_documento ="RUC";
                me.cliente.num_documento = "";
                me.cliente.razon_social = "";
                me.cliente.telefono = "";
                me.cliente.correo = "";
                me.cliente.direccion = "";
                me.opcionModal = 1;
                me.tituloModal = 'Registrar Proveedor'
            } else {
 
                me.cliente.nombre = data.nombre;
                me.cliente.tipo_documento = data.tipo_documento;
                me.cliente.num_documento  = data.num_documento;
                me.cliente.razon_social = data.razon_social;
                me.cliente.telefono = data.telefono;
                me.cliente.correo = data.correo;
                me.cliente.direccion = data.direccion;
                me.cliente.id = data.id;
                me.opcionModal = 0;
                me.tituloModal = 'Editar Proveedor'
            }
        },

        validarCliente(){
                let me = this;
                me.errorCliente=0;
                me.errorMostrarMsjCliente =[];
                $(".alert-danger").fadeTo(2000, 3000).slideUp(3000, function(){
                    $(".alert-danger").slideUp(3000);
                });

                if (me.encontrarCliente.length && me.opcionModal) me.errorMostrarMsjCliente.push("El proveedor ya existe.");
                if (me.cliente.num_documento.length < 8 && me.cliente.tipo_documento == 'DNI') me.errorMostrarMsjCliente.push("El número debe de tener 8 dígitos.");
                if (!me.cliente.nombre && me.cliente.tipo_documento == 'DNI') me.errorMostrarMsjCliente.push("El campo nombre no debe de estar nulo.");
                if (!me.cliente.razon_social && me.cliente.tipo_documento == 'RUC') me.errorMostrarMsjCliente.push("El campo Razón Social no debe de estar nulo.");
                if (me.errorMostrarMsjCliente.length) me.errorCliente = 1;
                return me.errorCliente;
            
        },

        registrarProveedor(){
            let me = this;
            let url = me.enlace+'/persona';

            if (me.validarCliente()) {
                return
            }

            swal({
                title: 'Está seguro registrar este proveedor?',
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
                            
                axios.post(url, me.cliente).then((res) =>{
                    $('#modalCliente').modal('hide')
                    $('#tablaCliente').DataTable().destroy();
                    me.listarCliente();
                })

            }});
               
        },

        editarCliente(){
            let me = this;

            if (me.validarCliente()) {
                return
            }

            const url = me.enlace+ '/persona';
            axios.put(url,{
                'tipo_persona':'Cliente',
                'nombre': me.cliente.nombre,
                'razon_social': me.cliente.razon_social,
                'correo': me.cliente.correo,
                'telefono': me.cliente.telefono,
                'direccion': me.cliente.direccion,
                'id':me.cliente.id

            }).then((res) => {
                swal({
                    type: "success",
                    title: "Éxito...",
                    text: "Cliente registrado!"
                });
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $('#tablaCliente').DataTable().destroy();
                me.listarCliente();
            });
        },

        actualizarCliente(data){
            let me = this;
            const url = (me.enlace+'/persona/estado');
            axios.put(url, {
                estado: data.estado,
                id: data.id
                }).then(function(response) {
                    swal({
                        type: "success",
                        title: "Éxito...",
                        text: "Estado actualizado!"
                    });
                    $("[data-dismiss=modal]").trigger({ type: "click" });
                    me.listarCliente();
                });
                
        },

        traerNombre(){
            let me = this;
            const url = me.enlace+'/persona/consultarnombre?num_documento='+me.cliente.num_documento+'&tipo_documento='+me.cliente.tipo_documento;
            axios.get(url).then((res) =>{
             
                if (me.cliente.num_documento.length >=11) {
                    me.cliente.razon_social = res.data.razon_social;
                }
            
            })
        },

        myTable(){
            this.$nextTick(() =>{
                $("#tablaCliente").DataTable({

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
        }
    },

    mounted(){
        this.listarCliente();
    }
    
}
</script>

<style scoped>

 input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none; 
    margin: 0; 
    }
</style>