<template>
    <div class="row">
        <!-- Cajas -->
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3 v-text="ventas"></h3>
                    <p>Ventas</p>
                </div>
                <div class="icon"> <i class="ion ion-social-usd"></i></div>
                <a href="#" class="small-box-footer" @click="$root.menu=7">Más info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3 v-text="ingresos"></h3>
                    <p>Compras</p>
                </div>
                <div class="icon"> <i class="ion ion-social-usd"></i></div>
                <a href="#" class="small-box-footer" @click="$root.menu=6">Más info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3 v-text="clientes"></h3>
                    <p>Clientes</p>
                </div>
                <div class="icon"> <i class="ion ion-person-add"></i></div>
                <a href="#" class="small-box-footer" @click="$root.menu=3">Más info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
 
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3 v-text="productos"></h3>
                    <p>Productos</p>
                </div>
                <div class="icon"> <i class="ion ion-ios-cart"></i></div>
                <a href="#" class="small-box-footer" @click="$root.menu=5">Más info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- Fin de cajas -->


        <!-- Grafico de ventas -->
        <div class="col-md-12 hidden-xs">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Rango de Ventas por mes</h3>
                </div>
                <!-- <div class="box-body">
                    <button type="button" class="btn btn-default" id="daterange-btn">
                        <span> <i class="fa fa-calendar"></i> Rango de fecha </span> <i class="fa fa-caret-down"></i>
                    </button>
                </div> -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-solid bg-red">
                                <div class="box-header">
                                    <i class="fa fa-th"></i>
                                    <h3 class="box-title">Gráfico de Ventas</h3>
                                </div>
                                <div class="box-body border-radius-none">
                                    <div class="chart" id="line-chart-venta" style="height: 250px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


          <!-- Grafico de ingresos -->
        <div class="col-md-12 hidden-xs">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Rango de Compras por mes</h3>
                </div>
                <!-- <div class="box-body">
                    <button type="button" class="btn btn-default" id="daterange-btn">
                        <span> <i class="fa fa-calendar"></i> Rango de fecha </span> <i class="fa fa-caret-down"></i>
                    </button>
                </div> -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-solid bg-blue">
                                <div class="box-header">
                                    <i class="fa fa-th"></i>
                                    <h3 class="box-title">Gráfico de Compras</h3>
                                </div>
                                <div class="box-body border-radius-none">
                                    <div class="chart" id="line-chart-ingreso" style="height: 250px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

      
        <!-- Grafico de dona -->
        <div class="col-lg-6 col-xs-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Top 5 de Producto más vendidos por mes</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="chart-responsive">
                                <canvas id="pieChart" height="200"></canvas>
                            </div>
                        </div>

                        <div class="col-md-5 col-xs-12">
                            <ul class="chart-legend clearfix">
                                <li v-for="(item,index) in arrayProductos" :key="item.id"><i :class="'fa fa-circle-o text-'+colores[index]"></i> {{item.descripcion}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            
                <div class="box-footer no-padding">
                    <ul class="nav nav-pills nav-stacked">
                        <li v-for="(item,index) in arrayProductos" :key="item.id">
                            <a>                                     
                                <img :src="item.ruta" class="img-thumbnail" width="60px" style="margin-right:10px">
                                {{item.descripcion}}
                                
                                <span  :class="'pull-right text-'+colores[index]">   
                                    {{Number((item.cantidad/calcularCantidadProducto)*100).toFixed(1)}}%
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
                
            </div>
        </div>

        <!-- Lista de productos -->
        <div class="col-lg-6 col-xs-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Productos con stock menor a 10</h3>
                </div>
                <div class="box-body">
                    <ul class="products-list product-list-in-box">
                        <li class="item" v-for="object in arraySintock" :key="object.id">
                            <div class="product-img">
                                <img  alt="Product Image" :src="object.ruta">
                            </div>
                            <div class="product-info">
                                <a href="" class="product-title">
                                   {{object.descripcion}}
                                    <span class="label label-danger pull-right" v-text="object.stock"></span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="box-footer text-center">

                    <a @click="$root.menu=5" class="uppercase">Ver todos los productos</a>
                
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import { stringify } from 'querystring';

export default {
    props:['enlace'],

    data(){
        return{
            // Grafico de ventas
            arrayFechaVenta:[],

            // Grafico de ingreso
            arrayFechaIngreso:[],


            // Grafico de donas
            arrayProductos:[],
            colores: ["red","green","yellow","aqua","purple","blue"],
            // "cyan","magenta","orange","gold"

            // Boxees
            ventas: 0,
            ingresos: 0,
            clientes:0,
            productos:0,

            //Lista de productos sin stock
            arraySintock: []
        }
    },

    computed:{
        // Calcular el total del producto para el porcentaje de la dona
        calcularCantidadProducto(){
            let me = this;
            let total = 0.00;
            for (let index = 0; index < me.arrayProductos.length; index++) {
                 total += Number(me.arrayProductos[index].cantidad);
            }
            return (total).toFixed(2);
        }
    },
    methods:{

        // iniciar(){

        //     let me = this;
        //     this.$nextTick(() =>{
        //         $(function () {
        //             $('#daterange-btn').daterangepicker(
        //             {
        //                 ranges   : {
        //                     'Hoy'       : [moment(), moment()],
        //                     // 'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        //                     // 'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
        //                     'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
        //                     'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
        //                     'Último mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        //                     },
        //                     startDate: moment().subtract(29, 'days'),
        //                     endDate  : moment()
        //                 },
        //                 function (start, end) {
        //                     $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        //                     let fechaInicial = start.format('YYYY-MM-DD');
        //                     let fechaFinal = end.format('YYYY-MM-DD');
        //                     // console.log("F.Inicial",fechaInicial," F.Final",fechaFinal);
        //                     // me.getVentas(fechaInicial, fechaFinal);
        //                     // let capturarRango = $("#daterange-btn2 span").html();
        //                 }
        //             )   
        //         })
        //     })
        // },

        getVentas(){
            let me = this;
            const url = me.enlace+'/reporte/rangoFechaVenta';
    
            axios.get(url).then((res)=>{
               me.arrayFechaVenta = res.data.venta;
               if (me.arrayFechaVenta.length) {
                   me.loadVenta();
               }
            });        
        },

          getIngreso(){
            let me = this;
            const url = me.enlace+'/reporte/rangoFechaIngreso';
    
            axios.get(url).then((res)=>{
               me.arrayFechaIngreso = res.data.ingreso;
               if (me.arrayFechaIngreso.length) {
                   me.loadIngreso();
               }
            });        
        },

        getProductos(){
            let me = this;
            const url = me.enlace+'/reporte/donaProducto';
            axios.get(url).then((res)=> {
                me.arrayProductos = res.data.productos;
                me.getLoadProducto();
            });
        },

        getBoxes(){
            let me = this;
            const url = me.enlace+ '/reporte/boxes';
            axios.get(url).then((res) =>{
                me.clientes = res.data.clientes;
                me.productos = res.data.productos;
                
                me.ventas = me.validarNull(res.data.ventas[0].total);
                
                me.ingresos = me.validarNull(res.data.ingresos[0].total);
            })
        },

        getListaSinStockProductos(){
            let me = this;
            const url = me.enlace+'/reporte/sinStockProducto';
            axios.get(url).then((res) => {
                me.arraySintock = res.data.productos;
            })
        },

        validarNull(num){
            if (num == null) {
                return 0;
            }else{
                return num;
            }
        },

        loadVenta(){

            let datos = [];
            let objeto = {};
            let me = this;

            me.arrayFechaVenta.map((i) => {
                datos.push({
                    y: i.anio+'-'+i.mes,
                    ventas: i.total
                })
                objeto = datos;
            })



            var line = new Morris.Line({
                element: 'line-chart-venta',
                resize: true,
                data: objeto,

                // {y: '2013 Q2', item1: 8432}
              
                xkey             : 'y',
                ykeys            : ['ventas'],
                labels           : ['ventas'],
                lineColors       : ['#efefef'],
                lineWidth        : 2,
                hideHover        : 'auto',
                gridTextColor    : '#fff',
                gridStrokeWidth  : 0.4,
                pointSize        : 4,
                pointStrokeColors: ['#efefef'],
                gridLineColor    : '#efefef',
                gridTextFamily   : 'Open Sans',
                preUnits         : 'S/. ',
                gridTextSize     : 10
            });

        },

        loadIngreso(){

            let datos = [];
            let objeto = {};
            let me = this;

            me.arrayFechaIngreso.map((i) => {
                datos.push({
                    y: i.anio+'-'+i.mes,
                    compras: i.total
                })
                objeto = datos;
            })



            var line = new Morris.Line({
                element: 'line-chart-ingreso',
                resize: true,
                data: objeto,

                // {y: '2013 Q2', item1: 8432}
              
                xkey             : 'y',
                ykeys            : ['compras'],
                labels           : ['compras'],
                lineColors       : ['#efefef'],
                lineWidth        : 2,
                hideHover        : 'auto',
                gridTextColor    : '#fff',
                gridStrokeWidth  : 0.4,
                pointSize        : 4,
                pointStrokeColors: ['#efefef'],
                gridLineColor    : '#efefef',
                gridTextFamily   : 'Open Sans',
                preUnits         : 'S/. ',
                gridTextSize     : 10
            });

        },

        getLoadProducto(){

            let me = this;
            let datos = [];
            let objeto = {};

            me.arrayProductos.map((i,index) => {
                datos.push({
                    value: i.cantidad,
                    color:me.colores[index],
                    highlight: me.colores[index],
                    label: i.descripcion
                })

                objeto = datos;
            })


                // JSON.stringify(objeto)
            this.$nextTick(() =>{

            var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
            var pieChart = new Chart(pieChartCanvas);
            var PieData =  objeto
            
            var pieOptions     = {
                segmentShowStroke    : true,
                segmentStrokeColor   : '#fff',
                segmentStrokeWidth   : 1,
                percentageInnerCutout: 50, 
                animationSteps       : 100,
                animationEasing      : 'easeOutBounce',
                animateRotate        : true,
                animateScale         : true,
                responsive           : false,
                maintainAspectRatio  : false,
                legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
                tooltipTemplate      : '<%=value %> <%=label%>'
            };
            pieChart.Doughnut(PieData, pieOptions);

            })
        },
        
    
    },


    mounted(){
        // this.iniciar();
        this.getBoxes();
        this.getVentas();
        this.getIngreso();
        this.getProductos();
        this.getListaSinStockProductos();
    }
}
</script>

