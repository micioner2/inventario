<template>

    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-align-justify"></i>Proveedores &nbsp; &nbsp;
            <button class="btn btn-primary" @click="abrirModal('registrar','')" data-toggle="modal" data-target="#modalProveedor" data-backdrop="static" data-keyboard="false"><i class="fa fa-plus"></i>&nbsp;&nbsp;Nuevo</button>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-hover table-striped" id="tablaProveedor">
                <thead>
                    <tr>
                        <th>Opciones</th>
                        <th>Tipo Documento</th>
                        <th>Número</th>
                        <th>Nombre</th>
                        <th>Razón Social</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="proveedor in filtrarProveedor" :key="proveedor.id" >
                        <td>
                            <button class="btn btn-primary btn-xs" @click="abrirModal('',proveedor)"  data-toggle="modal" data-target="#modalProveedor" data-backdrop="static" data-keyboard="false"><i class="fa fa-pencil"></i></button>&nbsp;&nbsp;
                        </td>
                        <td v-text="proveedor.tipo_documento"></td>
                        <td v-text="proveedor.num_documento"></td>
                        <td v-text="proveedor.nombre"></td>
                        <td v-text="proveedor.razon_social"></td>
                        <td v-text="proveedor.direccion"></td>
                        <td v-text="proveedor.telefono"></td>
                        <td v-text="proveedor.correo"></td>
                        <td><span v-text="proveedor.estado?'Acitvo':'Desactivado'" :class="proveedor.estado?'label label-primary':'label label-danger'"></span></td>
                    </tr>
                </tbody>
            </table>
        </div>
         

        <div class="modal fade" id="modalProveedor">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Registrar Proveedor</h4>
                    </div>
                        <div class="modal-body">
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >Tipo Doc. Identidad  </label>
                                    <select  class="form-control" v-model="proveedor.tipo_documento" :disabled="!opcionModal">
                                        <option value="DNI">DNI</option>
                                        <option value="RUC">RUC</option>
                                    </select>                    
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Numero<span style="color:red;" v-if="opcionModal" v-show="encontrarProveedor.length">    (proveedor ya existe) </span></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" :disabled="!opcionModal"  v-model="proveedor.num_documento" v-show="proveedor.tipo_documento=='DNI'"   maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" @keyup.enter="traerNombre()">
                                        <input type="number" class="form-control" :disabled="!opcionModal"  v-model="proveedor.num_documento" v-show="proveedor.tipo_documento=='RUC'"   maxlength="11" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" @keyup.enter="traerNombre()">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" @click="traerNombre()"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" class="form-control" v-model="proveedor.nombre"  @input="proveedor.nombre = $event.target.value.toUpperCase()">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Razón Social</label>
                                    <input type="text" class="form-control" v-model="proveedor.razon_social"  @input="proveedor.razon_social = $event.target.value.toUpperCase()">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Correo</label>
                                    <input type="text" class="form-control" v-model="proveedor.correo">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Teléfono</label>
                                    <input type="text" class="form-control" v-model="proveedor.telefono">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Dirección</label>
                                    <input type="text" class="form-control" v-model="proveedor.direccion">
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
                        <button type="submit" class="btn btn-primary pull-right" v-else @click="editarProveedor()">Editar</button>
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
            proveedores:[],

            proveedor: {
                id:0,
                tipo_documento:'DNI',
                num_documento:'',
                nombre:'',
                razon_social:'',
                correo: '',
                telefono:'',
                direccion:'',
            },

            opcionModal: 1,
            errorCliente: 0,
            errorMostrarMsjCliente: []
        }
    },

    computed:{

        filtrarProveedor(){
            let me = this;
            return me.proveedores.filter(proveedor => {
                return  proveedor;
            });
        },

        encontrarProveedor(){
            let me = this;
            return  me.filtrarProveedor.filter(i => i.num_documento === me.proveedor.num_documento);
           
        }
    },

    methods:{

        listarProveedor(){
            let me = this;
                let url = me.enlace+'/proveedor';
            axios.get(url).then((res) => {
                me.proveedores = res.data.proveedor;
                if (me.proveedores.length) {
                    me.myTable();
                }
            });
        },


        abrirModal(accion, data = []) {
            let me = this;
            if (accion == 'registrar') {
                me.proveedor.nombre = "";
                me.proveedor.tipo_documento ="DNI";
                me.proveedor.num_documento = "";
                me.proveedor.razon_social = "";
                me.proveedor.telefono = "";
                me.proveedor.correo = "";
                me.proveedor.direccion = "";
                me.opcionModal = 1;
            } else {
 
                me.proveedor.nombre = data.nombre;
                me.proveedor.tipo_documento = data.tipo_documento;
                me.proveedor.num_documento  = data.num_documento;
                me.proveedor.razon_social = data.razon_social;
                me.proveedor.telefono = data.telefono;
                me.proveedor.correo = data.correo;
                me.proveedor.direccion = data.direccion;
                me.proveedor.id = data.id;
                me.opcionModal = 0;
            }
        },


        validarCliente(){
            let me = this;
            me.errorCliente=0;
            me.errorMostrarMsjCliente =[];
            $(".alert-danger").fadeTo(2000, 3000).slideUp(3000, function(){
                $(".alert-danger").slideUp(3000);
            });

            if (me.encontrarProveedor.length && me.opcionModal) me.errorMostrarMsjCliente.push("El cliente ya existe.");
            if (me.proveedor.num_documento.length < 8 && me.proveedor.tipo_documento == 'DNI') me.errorMostrarMsjCliente.push("El número debe de tener 8 dígitos.");
            if (me.proveedor.num_documento.length < 11 && me.proveedor.tipo_documento == 'RUC') me.errorMostrarMsjCliente.push("El número debe de tener 11 dígitos.");
            if (!me.proveedor.nombre && me.proveedor.tipo_documento == 'DNI') me.errorMostrarMsjCliente.push("El campo nombre no debe de estar nulo.");
            if (!me.proveedor.razon_social && me.proveedor.tipo_documento == 'RUC') me.errorMostrarMsjCliente.push("El campo Razón Social no debe de estar nulo.");
            if (me.errorMostrarMsjCliente.length) me.errorCliente = 1;
            return me.errorCliente;
            
        },

        registrarProveedor(){
            let me = this;
            let url = me.enlace+'/proveedor';

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
                            
                axios.post(url, me.proveedor).then((res) =>{
                    $('#modalProveedor').modal('hide')
                    $('#tablaProveedor').DataTable().destroy();
                    me.listarProveedor();
                })

            }});
        },

        editarProveedor(){
            let me = this;
            const url = me.enlace+ '/proveedor';
            axios.put(url,{
                'nombre': me.proveedor.nombre,
                'razon_social': me.proveedor.razon_social,
                'correo': me.proveedor.correo,
                'telefono': me.proveedor.telefono,
                'direccion': me.proveedor.direccion,
                'id':me.proveedor.id

            }).then((res) => {
                swal({
                    type: "success",
                    title: "Éxito...",
                    text: "proveedor registrado!"
                });
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $('#tablaProveedor').DataTable().destroy();
                me.listarProveedor();
            });
        },


        traerNombre(){
            let me = this;
            const url = me.enlace+'/cliente/consultarnombre?num_documento='+me.proveedor.num_documento+'&tipo_documento='+me.proveedor.tipo_documento;
            axios.get(url).then((res) =>{
                if (me.proveedor.tipo_documento == "DNI") { 

                    if (me.proveedor.num_documento.length >= 8) {
                        me.proveedor.nombre = res.data;
                    }
                }else{

                    if (me.proveedor.num_documento.length >=11) {
                        me.proveedor.razon_social = res.data.razon_social;
                    }
                }
            })
        },

        myTable(){
            this.$nextTick(() =>{
                $("#tablaProveedor").DataTable({

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
        this.listarProveedor();
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