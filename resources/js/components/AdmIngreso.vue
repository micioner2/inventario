<template>
    <div class="row">
        <div class="col-lg-12 col-xs-12" v-if="opcionPagina">
            <div class="box box-primary">
                <div class="box box-header with-border">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button type="submit" @click="listarIngreso(1,buscar,criterio)" class="btn btn-info"><i class="fa fa-search"></i> Buscar</button>
                                </span>
                                <input type="text" v-model="buscar" @keyup.enter="listarIngreso(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                <span class="input-group-addon" style="width:0px; padding-left:0px; padding-right:0px; border:none;"></span>
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="numero_comprobante">Número Comprobante</option>
                                    <option value="tipo_comprobante">Tipo Comprobante</option>
                                    <option value="created_at">Fecha-Hora</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                  <tr>
                                        <th>#</th>
                                        <th>S/N. Comprobante</th>
                                        <th>Proveedor</th>
                                        <th>Vendedor</th>
                                        <th>Sub Total</th>
                                        <th>T. igv</th>
                                        <th>Total</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(ingreso,index) in arrayIngreso" :key="index" :class="ingreso.estado != 'Anulado' ? '':'text-danger'">
                                    <td v-text="(index+1)"></td>
                                    <td v-text="ingreso.serie_comprobante+' / ' +ingreso.numero_comprobante"></td>
                                    <td v-if="ingreso.tipo_comprobante != 'FACTURA'" v-text="ingreso.nombre" ></td>
                                    <td v-else v-text="ingreso.razon_social"></td>
                                    <td v-text="ingreso.usuario"></td>
                                    <td v-text="(ingreso.total/1.18).toFixed(2)"></td>
                                    <td v-text="(ingreso.total-(ingreso.total/(1.18))).toFixed(2)"></td>
                                    <td v-text="ingreso.total"></td>
                                    <td v-text="convertirFecha(ingreso.fecha)"></td>
                                    <td v-text="ingreso.estado"></td>
                                    <td>
                                        <button type="button"  class="btn btn-info btn-sm"><i class="fa fa-print"></i></button> &nbsp;
                                        <button type="button"  class="btn btn-warning btn-sm" @click="verIngreso(ingreso.id)"><i class="fa fa-eye"></i></button> &nbsp;
                                        <button type="button"  class="btn btn-danger btn-sm" @click="anularIngreso(ingreso.id)" v-if="ingreso.estado !='Anulado'"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="box-footer">
                    <div class="form-group">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">

                                <li v-if="pagination.current_page > 1">
                                    <a href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li  v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li  v-if="pagination.current_page < pagination.last_page">
                                    <a href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-xs-12" v-else>
            <div class="box box-primary">
                <div class="box box-header with-border">
                    <div class="row">
                        <div class="col-lg-10">         
                            <img class="foto"  src="logo_empresa/logo_empresa.jpg" width="80" height="80">
                            <h3 class="text-center"><b>{{cliente}}</b></h3>
                            <p class="text-center subtitulo" >RUC:{{num_documento}}</p>
                            <p class="text-center subtitulo" >Dirección: {{direccion}}</p>
                            <p class="text-center subtitulo">Telf:{{telefono}}</p>
                        </div>
                        <div class="col-lg-2 tipo_comprobante">
                            <h2 v-text="tipo_comprobante"></h2>
                        </div>
                    </div>
                </div>

                <div class="box-body cuerpo">
                    <!-- <div class="col-lg-6 col-md-4">
                        <div class="detalles">
                            <h4>DETALLES</h4>
                        </div>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Proveedor:</th>
                                    <td v-text="cliente"></td>
                                </tr>
                                <tr>
                                    <th>RUC</th>
                                    <td v-text="num_documento"></td>
                                </tr>
                                <tr>
                                    <th>Dirección:</th>
                                    <td v-text="direccion"></td>
                                </tr>
                                <tr>
                                    <th>Tel.:</th>
                                    <td v-text="telefono"></td>
                                </tr>
                            </thead>
                        </table>
                    </div> -->

 
                    <div class="col-lg-5 col-md-4">
                        <table class="table text-center">
                            <thead class="cabecera" >
                                <tr>
                                    <th>N° DE FACTURA</th>
                                    <th>FECHA</th>
                                    <th>ESTADO</th>
                                </tr>
                            </thead>
                            <tbody class="tabla-cuerpo">
                                <tr>
                                    <td v-text="numero_comprobante"></td>
                                    <td v-text="fecha"></td>
                                    <td v-text="estado"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-lg-12">
                        <div class="table table-responsive">
                            <table class="table table-bordered">
                                <thead class="cabecera">
                                    <tr>
                                        <th>DESCRIPCIÓN</th>
                                        <th>CANTIDAD</th>
                                        <th>PRECIO</th>
                                        <th>IMPORTE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                        <td v-text="detalle.descripcion"></td>
                                        <td v-text="detalle.cantidad"></td>
                                        <td v-text="detalle.precio"></td>
                                        <td v-text="(detalle.precio * detalle.cantidad).toFixed(2)"></td>
                                    </tr>
                                    <tr style="background-color: #CEECF5;">
                                        <td colspan="3" align="right"><strong>SUB TOTAL</strong></td>
                                        <td v-text="(calcularSubtotal).toFixed(2)"></td>
                                    </tr>
                                     <tr style="background-color: #CEECF5;">
                                        <td colspan="3" align="right"><strong>IGV</strong></td>
                                        <td v-text="(calcularIgv).toFixed(2)"></td>
                                    </tr>
                                     <tr style="background-color: #CEECF5;">
                                        <td colspan="3" align="right"><strong>TOTAL</strong></td>
                                        <td v-text="(calcularTotal).toFixed(2)"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="box-footer">
                    <button type="button" class="btn btn-default boton-pie" @click="opcionPagina = 1">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from "moment";
    export default {
        
        props:['enlace'],

        data(){
            return{

                arrayIngreso:[],
                arrayDetalle:[],

                cliente: '',
                num_documento:'',
                direccion:'',
                telefono:'',

                tipo_comprobante:'',
                fecha:'',
                numero_comprobante:'',
                estado:'',


                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'numero_comprobante',
                buscar : '',

                opcionPagina:1
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

            isActived: function(){
                return this.pagination.current_page;
            },
            
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            },

        },

        methods:{
            
            listarIngreso (page,buscar,criterio){
                let me=this;
                var url= this.enlace + '/ingreso?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayIngreso = respuesta.ingresos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            cambiarPagina(page,buscar,criterio){
                let me = this;

                me.pagination.current_page = page;
                me.listarIngreso(page,buscar,criterio);
            },

            verIngreso(id){
                let me = this;
                let arrayIngresoT=[];
                const url= me.enlace+'/ingreso/obtenerCabecera?id=' + id;
                axios.get(url).then((res) => {
                    arrayIngresoT = res.data.ingreso;

                        let tipo_comprobante = arrayIngresoT[0]['tipo_comprobante'];
                        if (tipo_comprobante == 'BOLETA') {
                            me.cliente = arrayIngresoT[0]['nombre'];
                        }else{
                            me.cliente = arrayIngresoT[0]['razon_social'];
                        }

                    me.num_documento = arrayIngresoT[0]['num_documento'];
                    me.direccion = arrayIngresoT[0]['direccion'];
                    me.telefono = arrayIngresoT[0]['telefono'];
                    me.fecha = me.convertirFecha(arrayIngresoT[0]['fecha']);
                    me.numero_comprobante = arrayIngresoT[0]['numero_comprobante'];
                    me.estado = arrayIngresoT[0]['estado'];
                    me.tipo_comprobante = arrayIngresoT[0]['tipo_comprobante'];
                });

                    const url2 = me.enlace+'/ingreso/obtenerDetalles?id='+id;
                    axios(url2).then((res) => {
                            me.arrayDetalle = res.data.detalles;
                    });
                    me.opcionPagina = 0;



            },

            anularIngreso(id){
            
                swal({
                    title: 'Está seguro de anular este ingreso?',
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
                        const url = me.enlace + '/ingreso/anular';
                        axios.put(url,{'id': id}).then((res) =>{
                            me.listarIngreso(1,'','numero_comprobante');
                        })
                }});

            },

            convertirFecha(date) {
                return moment(String(date)).format('YYYY-MM-DD');
            },

        },


        mounted(){
             this.listarIngreso(1,this.buscar,this.criterio);
        }

    }

</script>


<style scoped>

.foto{
    float: left;
    margin-left: 14px;
}

.subtitulo{
   margin-top:-10px;
}

.tipo_comprobante{
     color: #4875CA;
     font-weight: 900;
}

.detalles, .cabecera{
    background: #4875CA;
    color: #fff;
    padding: 1px;
    text-align:center;
}

.cuerpo{
    margin-top: -20px;
}

.boton-pie{
    margin-left: 14px;
}


</style>