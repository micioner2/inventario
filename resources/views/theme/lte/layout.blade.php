<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" href="logo_empresa/icono.png">
  <title>Sistema | Venta</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 

<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="{{asset("assets/$theme/bower_components/bootstrap/dist/css/bootstrap.min.css")}}">

<!-- Font Awesome -->
<link rel="stylesheet" href="{{asset("assets/$theme/bower_components/font-awesome/css/font-awesome.min.css")}}">

<!-- Ionicons -->
<link rel="stylesheet" href="{{asset("assets/$theme/bower_components/Ionicons/css/ionicons.min.css")}}">

 <!-- Daterange picker -->
 <link rel="stylesheet" href="{{asset("assets/$theme/bower_components/bootstrap-daterangepicker/daterangepicker.css")}}">

 <!-- Select2 for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{asset("assets/$theme/bower_components/select2/dist/css/select2.min.css")}}">

 <!-- DataTables -->
<link rel="stylesheet" href="{{asset("assets/$theme/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css")}}">
<link rel="stylesheet" href="{{asset("assets/$theme/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css")}}">

<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

<!-- Morris chart -->
<link rel="stylesheet" href="{{asset("assets/$theme/bower_components/morris.js/morris.css")}}">
    
<!-- Theme style -->
<link rel="stylesheet" href="{{asset("assets/$theme/dist/css/AdminLTE.css")}}">

<!-- AdminLTE Skins -->
<link rel="stylesheet" href="{{asset("assets/$theme/dist/css/skins/_all-skins.min.css")}}">


</head>

<body class="hold-transition skin-blue fixed sidebar-mini">
    <div id="app">
        <div class="wrapper">
        
                {{-- INICIO HEADER --}}
                    @include("theme/$theme/header")
                {{-- FIN-HEADER --}}

                {{-- ASIDE --}}
                    @include("theme/$theme/aside")
                {{-- FIN-ASIDE --}}

                <div class="content-wrapper">
                    <section class="content">
                        @yield('contenido')
                    </section>
                </div>
                @include("theme/$theme/footer")
            </div>
        </div>

<script src="{{asset("assets/$theme/bower_components/jquery/dist/jquery.min.js")}}"></script> 

<!-- Select2 -->
<script src="{{asset("assets/$theme/bower_components/select2/dist/js/select2.full.min.js")}}"></script>

<script src="{{asset("assets/js/app.js")}}"></script>
<script src="{{asset("assets/js/plantilla.js")}}"></script>

 <script src="{{asset("assets/$theme/bower_components/datatables.net/js/jquery.dataTables.min.js")}}"></script>
 <script src="{{asset("assets/$theme/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js")}}"></script>

<!-- Bootstrap 3.3.7 -->
<script src="{{asset("assets/$theme/bower_components/bootstrap/dist/js/bootstrap.min.js")}}"></script>

<script src="{{asset("assets/$theme/dist/js/adminlte.min.js")}}"></script>



<!-- date-range-picker -->
<script src="{{asset("assets/$theme/bower_components/moment/min/moment.min.js")}}"></script>
<script src="{{asset("assets/$theme/bower_components/bootstrap-daterangepicker/daterangepicker.js")}}"></script>

<!-- SlimScroll -->
<script src="{{asset("assets/$theme/bower_components/jquery-slimscroll/jquery.slimscroll.min.js")}}"></script>

 <!-- ChartJS -->
 <script  src="{{asset("assets/$theme/bower_components/chart.js/Chart.min.js")}}"></script>

 <!-- Morris.js charts-->
<script src="{{asset("assets/$theme/bower_components/raphael/raphael.min.js")}}"></script>
<script src="{{asset("assets/$theme/bower_components/morris.js/morris.min.js")}}"></script>


</body>