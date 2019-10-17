<template>
    <!-- MODAL CLIENTE -->
    <div class="modal fade" id="modalCliente">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" @click="cerrarModal()">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" v-text="opcion == 0?'Registrar Cliente':'Registrar Proveedor'"></h4>
                </div>

                <div class="modal-body">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label >Tipo Doc. Identidad  </label>
                            <select  class="form-control" v-model="cliente.tipo_documento" :disabled="!opcionModal">
                                <option v-if="opcion == 0" value="DNI">DNI</option>
                                <option value="RUC">RUC</option>
                            </select>                    
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Numero<span style="color:red;" v-if="opcionModal" v-show="encontrarCliente.length">    (Cliente ya existe) </span></label>
                            <div class="input-group">
                                <input type="number" class="form-control" :disabled="!opcionModal"  v-model="cliente.num_documento" v-show="cliente.tipo_documento=='DNI'"   maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" @keyup.enter="traerNombre()">
                                <input type="number" class="form-control" :disabled="!opcionModal"  v-model="cliente.num_documento" v-show="cliente.tipo_documento=='RUC'"   maxlength="11" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" @keyup.enter="traerNombre()">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" @click="traerNombre()"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" v-model="cliente.nombre"  @input="cliente.nombre = $event.target.value.toUpperCase()">
                        </div>
                    </div>

                    <div class="col-md-6">
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
                            <input type="text" class="form-control" v-model="cliente.direccion" @input="cliente.direccion = $event.target.value.toUpperCase()">
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
                    <button type="button" class="btn btn-default pull-left" @click="cerrarModal()">Cerrar</button>
                    <button type="submit" class="btn btn-primary pull-right" v-if="opcionModal && opcion == 0" @click="registrarCliente()">Registrar</button>
                    <button type="submit" class="btn btn-primary pull-right" v-if="opcionModal && opcion == 1" @click="registrarProveedor()">Registrar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions} from 'vuex'
    export default {
        props:['enlace','opcion'],
        data(){
            return {
                
            clientes: [],
            cliente: {
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
            ...mapActions(['listarCliente','listarProveedor']),

            listarClientes(){
                let me = this;
                const url = me.enlace+'/cliente';
                axios.get(url).then((res) => {
                    me.clientes = res.data.cliente;
                });
            },

            traerNombre(){
                let me = this;
                const url = me.enlace+'/cliente/consultarnombre?num_documento='+me.cliente.num_documento+'&tipo_documento='+me.cliente.tipo_documento;
                axios.get(url).then((res) =>{
                    if (me.cliente.tipo_documento == "DNI") { 

                        if (me.cliente.num_documento.length >= 8) {
                            me.cliente.nombre = res.data;
                        }
                    }else{

                        if (me.cliente.num_documento.length >=11) {
                            me.cliente.razon_social = res.data.razon_social;
                        }
                    }
                })
            },
                
            validarCliente(){
                let me = this;
                me.errorCliente=0;
                me.errorMostrarMsjCliente =[];
                $(".alert-danger").fadeTo(2000, 3000).slideUp(3000, function(){
                    $(".alert-danger").slideUp(3000);
                });

                if (me.encontrarCliente.length && me.opcionModal) me.errorMostrarMsjCliente.push("El cliente ya existe.");
                if (me.cliente.num_documento.length < 8 && me.cliente.tipo_documento == 'DNI') me.errorMostrarMsjCliente.push("El número debe de tener 8 dígitos.");
                if (me.cliente.num_documento.length < 11 && me.cliente.tipo_documento == 'RUC') me.errorMostrarMsjCliente.push("El número debe de tener 11 dígitos.");
                if (!me.cliente.nombre && me.cliente.tipo_documento == 'DNI') me.errorMostrarMsjCliente.push("El campo nombre no debe de estar nulo.");
                if (!me.cliente.razon_social && me.cliente.tipo_documento == 'RUC') me.errorMostrarMsjCliente.push("El campo Razón Social no debe de estar nulo.");
                if (me.errorMostrarMsjCliente.length) me.errorCliente = 1;
                return me.errorCliente;      
            },

            registrarCliente(){
                let me = this;
                let url = me.enlace+'/cliente';

                if (me.validarCliente()) {
                    return
                }

                swal({
                    title: 'Está seguro registrar este cliente?',
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
                        $('#modalCliente').modal('hide');
                        me.listarCliente();
                        me.limpiarCliente();
                    })
                }});
               
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
                                
                    axios.post(url, me.cliente).then((res) =>{
                        $('#modalCliente').modal('hide');
                        me.listarProveedor();
                        me.limpiarCliente();
                    })
                }});
               
            },

            limpiarCliente(){
                let me = this;
                me.listarClientes();
                me.cliente.nombre = '';
                me.cliente.id=0
                me.cliente.tipo_documento='DNI'
                me.cliente.num_documento=''
                me.cliente.nombre=''
                me.cliente.razon_social=''
                me.cliente.correo= ''
                me.cliente.telefono=''
                me.cliente.direccion=''
            },

            cerrarModal(){
                $('#modalCliente').modal('hide')
            }

        },

        mounted(){
            if (this.opcion==1) {
                this.cliente.tipo_documento = "RUC"
                this.listarClientes();
            }else{
                this.listarProveedor();
            }
        }
    }
</script>