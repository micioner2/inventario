<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistema Laravel | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
   
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">


      <link rel="stylesheet" href="{{asset("assets/$theme/bower_components/bootstrap/dist/css/bootstrap.min.css")}}">

      <!-- Font Awesome -->
      <link rel="stylesheet" href="{{asset("assets/$theme/bower_components/font-awesome/css/font-awesome.min.css")}}">
      <!-- Ionicons -->
      <link rel="stylesheet" href="{{asset("assets/$theme/bower_components/Ionicons/css/ionicons.min.css")}}">


      <!-- Theme style -->
      <link rel="stylesheet" href="{{asset("assets/$theme/dist/css/AdminLTE.min.css")}}">


  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
      <a href="#"><b>Sistema</b> Punto de Venta</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Registro en el sistema</p>
       
        <form action="register" method="post">
      <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">   
          
          <div class="form-group has-feedback">
            <label>Usuario</label>
            <input type="text" class="form-control" name="usuario" >
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>


          <div class="form-group has-feedback">
              <label>password</label>
            <input type="password" class="form-control" name="password" >
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>


         
          <div class="row">
            
          
            
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Registrar</button>
            </div>
            
            <div class="col-xs-2">
            </div>
            <div class="col-xs-6">
                <a href="login"><p>Ya estoy registrado</p></a>
            </div>
          </div>
        </form>

     
       

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <script src="{{asset("assets/js/plantilla.js")}}"></script>

    
  </body>
</html>
