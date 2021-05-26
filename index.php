<?php 
//Configuracion de la conexion a base de datos
include('_conexion.php');

session_start();

if ($_POST['usuario'] != ''){
  $cl=md5($_POST['clave']);
  #echo 'usr: '.$_POST['usuario'].' && pass:'.$cl;
  $sql="SELECT aliasnomb, idusu FROM usuarios WHERE aliasnomb='".$_POST['usuario']."' and clave='".$cl."'";
  $consulta=pg_query($con, $sql)or die ("Problemas en consulta ".pg_last_error ());
  $cant=pg_num_rows($consulta);
  $dt=pg_fetch_array($consulta);
  
    if ($cant > 0)
    {
      $sql1="SELECT idcaja FROM detcaja WHERE irl = ".$_POST['caja'];
      $cons=pg_query($con, $sql1)or die ("Problemas en consulta ".pg_last_error ());
      $ca=pg_fetch_array($cons);
      $sql2="SELECT nrocaja, idsucursal, timb, timbrado FROM cajas WHERE idcaja=".$ca['idcaja'];
      $cons2=pg_query($con, $sql2)or die ("Problemas en consulta ".pg_last_error ());
      $nca=pg_fetch_array($cons2);

      unset($_SESSION['login_idusu']);
      unset($_SESSION['login_user']);
      unset($_SESSION['login_caja']);
      unset($_SESSION['login_deposito']);
      unset($_SESSION['login_nrocaja']);
      unset($_SESSION['login_sucursal']);
      $_SESSION['login_idusu'] = $dt['idusu'];
      $_SESSION['login_user'] = $dt['aliasnomb'];
      $_SESSION['login_caja'] = $_POST['caja'];
      $_SESSION['login_vendedor'] = $_POST['vendedor'];
      $_SESSION['login_deposito'] = $_POST['deposito'];
      $_SESSION['login_nrocaja'] = $nca['nrocaja'];
      $_SESSION['login_sucursal'] = $nca['idsucursal'];
      $_SESSION['login_timb'] = $nca['timb'];
      $_SESSION['login_timbrado'] = $nca['timbrado'];

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
          <div class="input-group">
            <div class="input-group-addon"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span></div>
             <SELECT NAME="caja" id="caja" class="form-control"> 
              <OPTION VALUE="0">Caja</OPTION> 
              <?php 
              $sql1="SELECT irl, idcaja FROM detcaja WHERE cierre = '1900-01-01 00:00:00'";
              $cons=pg_query($con, $sql1)or die ("Problemas en consulta ".pg_last_error ());
              while($ca=pg_fetch_array($cons)){
               $sql2="SELECT nrocaja FROM cajas WHERE idcaja=".$ca['idcaja'];
               $cons2=pg_query($con, $sql2)or die ("Problemas en consulta ".pg_last_error ());
               $nca=pg_fetch_array($cons2);
               echo '<OPTION VALUE="'.$ca['irl'].'">'.$nca['nrocaja'].'</OPTION> ';
              }?>
              
            </SELECT>
          </div>
        </div>

        <div class="input-group mb-3"> 
          <div class="input-group">
            <div class="input-group-addon"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span></div>
             <SELECT NAME="deposito" id="deposito" class="form-control"> 
              <OPTION VALUE="0">Deposito</OPTION> 
              <?php 
              $sql1="SELECT iddeposito, nombres FROM depositos";
              $cons=pg_query($con, $sql1)or die ("Problemas en consulta ".pg_last_error ());
              while($ca=pg_fetch_array($cons)){
               echo '<OPTION VALUE="'.$ca['iddeposito'].'">'.$ca['nombres'].'</OPTION> ';
              }?>
            </SELECT>
          </div>
        </div>

        <div class="input-group mb-3"> 
          <div class="input-group">
            <div class="input-group-addon"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span></div>
             <SELECT NAME="vendedor" id="vendedor" class="form-control"> 
              <OPTION VALUE="0">Vendedor</OPTION> 
              <?php 
              $sql1="SELECT idvend, nombres FROM vendedores";
              $cons=pg_query($con, $sql1)or die ("Problemas en consulta ".pg_last_error ());
              while($ca=pg_fetch_array($cons)){
               echo '<OPTION VALUE="'.$ca['idvend'].'">'.$ca['nombres'].'</OPTION> ';
              }?>
              
            </SELECT>
          </div>
        </div>

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
