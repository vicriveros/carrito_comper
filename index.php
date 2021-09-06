<?php 
session_start();
//Configuracion de la conexion a base de datos
include('_conexion.php');

if ($_POST['usuario'] != ''){
  $cl=md5($_POST['clave']);
  $sql="SELECT aliasnomb, idusu, idcaja, idvend, iddeposito FROM usuarios WHERE btrim(aliasnomb)='".$_POST['usuario']."' and clave='".$cl."'";
  $consulta=pg_query($con, $sql)or die ("Problemas en consulta ".pg_last_error ());
  $cant=pg_num_rows($consulta);
  $dt=pg_fetch_array($consulta);
  
    if ($cant > 0)
    {
      $sql2="SELECT a.nrocaja, a.idsucursal, a.timb, b.nro_timbrado as timbrado, b.idtimb FROM cajas a inner join timbrados b on a.idcaja=b.idcaja WHERE b.idcaja=".$dt['idcaja'].' and b.activo=1 and b.tipo_doc=1';
      $cons2=pg_query($con, $sql2)or die ("Problemas en consulta ".pg_last_error ());
      $nca=pg_fetch_array($cons2);

      unset($_SESSION['login_idusu']);
      unset($_SESSION['login_user']);
      unset($_SESSION['login_idcaja']);
      unset($_SESSION['login_deposito']);
      unset($_SESSION['login_nrocaja']);
      unset($_SESSION['login_sucursal']);
      $_SESSION['login_idusu'] = $dt['idusu'];
      $_SESSION['login_user'] = $dt['aliasnomb'];
      $_SESSION['login_vendedor'] = $dt['idvend'];
      $_SESSION['login_deposito'] = $dt['iddeposito'];
      $_SESSION['login_idcaja'] = $dt['idcaja'];
      $_SESSION['login_sucursal'] = $nca['idsucursal'];
      $_SESSION['login_timb'] = $nca['timb'];
      $_SESSION['login_timbrado'] = $nca['timbrado'];
      $_SESSION['login_idtimb'] = $nca['idtimb'];
      $_SESSION['login_nrocaja'] = $nca['nrocaja'];


      echo '<script>location.href="cabecera.php";</script>';
      
    }
}
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Proyectos - e | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Punto</b> de Ventas</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Iniciar Sesion</p>

      <form action="index.php" method="post">

        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Usuario" name="usuario" id="usuario">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Contraseña" name="clave" id="clave">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        
      <div class="social-auth-links text-center mb-3">
        <button id="enviar" type="submit" class="btn btn-block btn-primary">Acceder</button>  
      </div>
      <!-- /.social-auth-links -->
</form>
      
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>
