<template>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="box box-primary">

                <div class="box-header">
                    <div class="row">
                         <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
                             <button type="button" class="btn btn-primary" @click="abrirModal('registrar')"  data-toggle="modal" data-target="#modalCategoria" data-backdrop="static" data-keyboard="false"><i class="fa fa-plus"></i>&nbsp;&nbsp;Nuevo</button>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="box-body with-boder table-responsive no-padding">
                     
                    <table class="table table-striped" id="tablaCategoria">
                        <thead>
                            <tr>
                                <th>Acciones</th>
                                <th>Nombre</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>    
                            <tr v-for="item in categorias" :key="item.id">
                                <td>
                                    <button type="button" class="btn btn-primary btn-xs" @click="abrirModal('editar',item)" data-toggle="modal" data-target="#modalCategoria" data-backdrop="static" data-keyboard="false"><i class="fa fa-pencil"></i></button>
                                    <button type="button" class="btn btn-danger btn-xs" @click="updCategoria(item)" v-show="item.estado"><i class="fa fa-trash"></i></button>
                                    <button type="button" class="btn btn-success btn-xs" @click="updCategoria(item)" v-show="item.estado !=1"><i class="fa fa-check"></i></button>
                                
                                </td>
                                <td v-text="item.nombre"></td> 
                                <td>
                                    <span v-text="item.estado?'Acitvo':'Desactivado'" :class="item.estado?'label label-primary':'label label-danger'"></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                </div> 
            </div>
        </div>

        <div class="modal  fade" id="modalCategoria">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modales">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                    </div>
                    
                        <div class="modal-body">
                            <form class="form">
                                <div class="box-body">

                                     <div v-show="errorCategoria" class="form-group row div-error">
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <div  class="text-center" v-text="errorMostrarMsjCategoria"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-th"></i></span>  
                                            <input class="form-control input-lg" type="text" placeholder="Ingrese nombre de categoría" v-model="categoria.nombre"  @input="categoria.nombre = $event.target.value.toUpperCase()"> 
                                            <input type="hidden">
                                        </div>
                                    </div>

                                </div>
                            </form>      
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary pull-right" v-if="opcionModal" @click="regCategoria()">Registrar</button>
                            <button type="submit" class="btn btn-primary pull-right" v-else @click="editCategoria()">Editar</button>
                        </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

// import datatables from 'datatables-bootstrap3-plugin'

export default {

    props: ['enlace'],


    data(){
        return{

            categoria:{
                id:0,
                nombre:'',
                estado:true,
            },
            categorias:[],
            opcionModal: 1,
            tituloModal:'',
            errorCategoria:0,
            errorMostrarMsjCategoria:''
          
        }
    },

 
    methods:{

      
        getCategorias(){
            let me = this;
            const url = me.enlace + '/categoria';
            axios.get(url).then((res) =>{
                me.categorias = res.data.categoria;
                if (me.categorias.length) {
                    me.myTable();
                }
            });

        },

        regCategoria(){
            let me = this;
            if (!me.categoria.nombre) {
                $(".alert-danger").fadeTo(2000, 500).slideUp(500, function(){
                    $(".alert-danger").slideUp(500);
                });
                me.errorMostrarMsjCategoria = 'El nombre de la categoría no debe de estar vacío.';
                if (me.errorMostrarMsjCategoria.length) me.errorCategoria = 1;

                return me.errorProducto;
            }else{
                const url = me.enlace + '/categoria';
                axios.post(url,me.categoria).then((resp)=>{
                    $("[data-dismiss=modal]").trigger({ type: "click" });
                    $('#tablaCategoria').DataTable().destroy();
                    me.getCategorias();
                });
            }
        },

        editCategoria(){
            let me = this;
            const url = me.enlace + '/categoria';
            axios.put(url,me.categoria).then((resp)=>{
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $('#tablaCategoria').DataTable().destroy();
                me.getCategorias();
            });
        },

        updCategoria(data){
            let me = this;
            const url = (me.enlace+'/categoria/estado');
            axios.put(url,data).then(function(response) {
                    swal({
                        type: "success",
                        title: "Éxito...",
                        text: "Estado actualizado!"
                    });
                    $('#tablaCategoria').DataTable().destroy();
                        me.getCategorias()
                });
            
        },

        abrirModal(opcion,data){
            let me = this;
            switch(opcion){
                case 'registrar':{
                    me.opcionModal = 1;
                    me.categoria.nombre = '';
                    me.categoria.estado = 1;
                    me.tituloModal = 'Registar Categoría';
                }
                break;

                case 'editar':{
                    me.opcionModal = 0;
                    me.categoria.nombre = data.nombre;
                    me.categoria.estado = data.estado;
                    me.categoria.id = data.id;
                    me.tituloModal = 'Editar Categoría';
                }
            }
        },
        
        myTable(){
            this.$nextTick(() =>{
                $("#tablaCategoria").DataTable({

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
            


    created()
    {
        this.getCategorias();
    },


}

</script>
