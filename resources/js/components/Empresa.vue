<template>
    <div class="row">
         <div class="col-lg-12">
             <div class="box box-danger">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-align-justify"></i>&nbsp;&nbsp;Empresa</h3>&nbsp;&nbsp;
                        <button class="btn btn-primary" v-if="!arrayEmpresa.length" @click="abrirModal('')" data-toggle="modal" data-target="#modal-empresa" data-backdrop="static" data-keyboard="false"><i class="fa fa-plus"></i>&nbsp;&nbsp;Nuevo</button>
                    </div>

                    <div class="box-body with-border">
                        <div class="table table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Opción</th>
                                        <th>Razón Social</th>
                                        <th>RUC</th>
                                        <th>Dirección</th>
                                        <th>Telf</th>
                                        <th>Logo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(empresa,index) in arrayEmpresa" :key="index">
                                        <td>
                                            <button class="btn btn-success" @click="abrirModal('editar',empresa)" data-toggle="modal" data-target="#modal-empresa" data-backdrop="static" data-keyboard="false"><i class="fa fa-pencil"></i></button>
                                        </td>
                                        <td v-text="empresa.razon_social"></td>
                                        <td v-text="empresa.ruc"></td>
                                        <td v-text="empresa.direccion"></td>
                                        <td v-text="empresa.telefono"></td>
                                        <td>
                                            <img :src="empresa.ruta" width="50" class="img-thumbnail">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal  fade" id="modal-empresa">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                    </div>
                    
                        <div class="modal-body">
                            <form class="form">
                                <div class="box-body">
                                    <div class="row">
                                                                                                                        
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Razón Social</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>  
                                                    <input class="form-control" type="text" v-model="razon_social" placeholder="Ingrese Razón Social"> 
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">RUC</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>  
                                                    <input class="form-control" type="text" v-model="ruc" placeholder="Ingrese RUC"> 
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Teléfono</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>  
                                                    <input class="form-control" type="text" v-model="telefono" placeholder="Ingrese Teléfono"> 
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Dirección</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>  
                                                    <input class="form-control" type="text" v-model="direccion" placeholder="Ingrese Dirección"> 
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Logo de empresa</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-camera"></i></span> 
                                                    <input type="file" class="form-control" ref="file" @change="onUploadImagen($event)">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <img :src="img" height="150px" width="150px" class="img-thumbnail">
                                                <button type="button" class="btn btn-success btn-xs" @click="limpiarFoto()"><i class="fa fa-file-image-o"></i>&nbsp; &nbsp; Limpiar Foto</button>
                                            </div>
                                        </div>

                                    </div>
                                  
                                </div>
                            </form>      
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary pull-right" v-if="opcionModal" @click="registrarEmpresa()">Registrar</button>
                            <button type="submit" class="btn btn-primary pull-right" v-else @click="editarEmpresa()">Editar</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['enlace'],
    
    data: () =>{
        return{
            tituloModal:'',
            opcionModal:1,

            id: 0,
            razon_social:'',
            ruc:'',
            direccion:'',
            telefono:'',
            img:'',
            ruta:null,
            arrayEmpresa:[],


            img:'logo_empresa/logo-compania.png',
            imagenActual: null,
        }
    },

    methods:{
        getEmpresa(){
            let me = this;
            let url = me.enlace + '/empresa';
            axios.get(url).then((res) => {
                me.arrayEmpresa = res.data.empresa;
            });
        },
        
        registrarEmpresa(){
            let me = this;
            let url = me.enlace +'/empresa/registrar';
            swal({
                title: 'Está seguro de registar esta empresa?',
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
                if(result.value){
                    const formData = new FormData();
                    formData.append('razon_social',me.razon_social);
                    formData.append('ruc',me.ruc);
                    formData.append('direccion',me.direccion);
                    formData.append('telefono',me.telefono);
                    formData.append('ruta',me.ruta);
                    axios.post(url, formData).then((res) => {
                        $("[data-dismiss=modal]").trigger({ type: "click" });
                        me.getEmpresa();
                    });
                }
            });
        },
        
        editarEmpresa(){
            let me = this;
            let url = me.enlace +'/empresa/editar';
            swal({
                title: 'Está seguro de editar los datos de esta empresa?',
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
                if(result.value){
                    const formData = new FormData();
                    formData.append('id', me.id);
                    formData.append('razon_social',me.razon_social);
                    formData.append('ruc',me.ruc);
                    formData.append('direccion',me.direccion);
                    formData.append('telefono',me.telefono);
                    formData.append('imagenActual', me.imagenActual);
                    formData.append('ruta',me.ruta);
                    axios.post(url, formData).then((res) => {
                        $("[data-dismiss=modal]").trigger({ type: "click" });
                        me.getEmpresa();
                    });
                }
            });
        },

        abrirModal(accion,data){
            let me = this;
            if(accion != 'editar'){
                me.tituloModal = 'Registrar Empresa';
                me.razon_social = '';
                me.ruc = '';
                me.direccion = '';
                me.telefono = '';
                me.limpiarFoto();
                me.opcionModal = 1;
            }else{
                me.tituloModal = 'Editar Empresa';
                me.id = data.id;
                me.razon_social = data.razon_social;
                me.ruc = data.ruc;
                me.telefono = data.telefono;
                me.direccion = data.direccion;
                me.ruta = data.ruta;
                me.imagenActual = data.ruta;
                me.img = data.ruta;
                me.opcionModal = 0;
            }
        },

        onUploadImagen(e) {
            let me = this;
            me.ruta = this.$refs.file.files[0];
            let file  = e.target.files[0];
            let fileReader = new FileReader();
            if (file && file.type.match('image.*')) {
                fileReader.readAsDataURL(e.target.files[0]);
                fileReader.onload = (e) => {
                    me.img = e.target.result
                }
            }else{
                me.limpiarFoto();
            }
        },

        limpiarFoto() {
            // const input = this.$refs.file
            // input.type = 'text'
            // input.type = 'file'
            this.$refs.file.value = null;
            this.ruta = '';
            this.img='logo_empresa/logo-compania.png'
        }
    },

    mounted() {
        this.getEmpresa();
    }
}
</script>