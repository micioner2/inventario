<template>
    <!-- MODAL CLIENTE -->
    <div class="modal fade" id="modalCliente">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" @click="cerrarModal()">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Registrar Proveedor</h4>
                </div>

                <div class="modal-body">

                    <form class="form">
                        <div class="box-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label >Tipo Doc. Identidad  </label>
                                        <select  class="form-control" v-model="cliente.tipo_documento">
                                            <option value="RUC">RUC</option>
                                        </select>                    
                                    </div>
                                </div>

                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                          <label>Numero<span style="color:red;"  v-show="encontrarProveedor.length">    (Proveedor ya existe) </span></label>
                                        <div class="input-group">
                                            <!-- <input type="number" class="form-control"   maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" @keyup.enter="traerNombre()"> -->
                                            <input type="number" class="form-control" v-model="cliente.num_documento"   maxlength="11" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" @keyup.enter="traerNombre()">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>


                                            
                                <div class="col-md-12">
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

                                <div v-show="errorProveedor" class="form-group row div-error">
                                    <div class="col-md-12">
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <ul>
                                                <li v-for="error in errorMostrarMsjProveedor" :key="error" v-text="error"></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>

                   


                    <!-- <div class="col-md-12" v-if="tipo_documento == 'DNI'">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control"  v-model="cliente.nombre"  @input="cliente.nombre = $event.target.value.toUpperCase()">
                        </div>
                    </div> -->


                    
                
    
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <button type="button" class="btn btn-default pull-left" @click="cerrarModal()">Cerrar</button>
                        <button type="submit" class="btn btn-primary pull-right" @click="registrarProveedor()">Registrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapState,mapActions} from 'vuex'
    export default {
        props:['enlace'],
        data(){
            return {
                
                cliente: {
                    id:0,
                    tipo_persona:'Proveedor',
                    tipo_documento:'RUC',
                    num_documento:'',
                    nombre:'',
                    razon_social:'',
                    correo: '',
                    telefono:'',
                    direccion:'',
                },
                errorMostrarMsjProveedor:[],
                errorProveedor:0

            }
        },
        computed:{

            filtrarProveedor(){   
                let me = this;
                return me.proveedores.filter(proveedor => {
                    return  proveedor.num_documento;
                });
            },

             encontrarProveedor(){
                let me = this;
                return  me.filtrarProveedor.filter(i => i.num_documento === me.cliente.num_documento);
            },

             ...mapState(['proveedores'])


        },
        methods:{
            ...mapActions(['listarProveedor']),
            
            traerNombre(){
                let me = this;
                let url = ''
    
                if (me.cliente.num_documento.length >= 11) {
                    url = me.enlace+'/consultarruc?ruc='+me.cliente.num_documento+''
                    axios.get(url).then((res) =>{

                        if (res.data.success) {
                            me.cliente.razon_social = res.data.nombre_o_razon_social
                            me.cliente.direccion = res.data.direccion
                        }else{
                            me.cliente.razon_social = ''
                            me.cliente.direccion = ''
                        }
                    })
                }
            },
            

              validarProveedor(){
                let me = this;
                me.errorProveedor=0;
                me.errorMostrarMsjProveedor =[];
                $(".alert-danger").fadeTo(2000, 3000).slideUp(3000, function(){
                    $(".alert-danger").slideUp(3000);
                });
                if (me.encontrarProveedor.length) me.errorMostrarMsjProveedor.push("El proveedor ya existe.");
                if (me.cliente.num_documento.length < 11 && me.cliente.tipo_documento == 'RUC') me.errorMostrarMsjProveedor.push("El número debe de tener 11 dígitos.");
                if (!me.cliente.razon_social && me.cliente.tipo_documento == 'RUC') me.errorMostrarMsjProveedor.push("El campo Razón Social no debe de estar nulo.");
                if (me.errorMostrarMsjProveedor.length) me.errorProveedor = 1;
                return me.errorProveedor;      
            },

            registrarProveedor(){
                let me = this;
                let url = me.enlace+'/persona';

                if (me.validarProveedor()) {
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
                    })

                }})
               
            },

            cerrarModal(){
                $('#modalCliente').modal('hide')
            }
        }

     
    }
</script>

<style>



</style>