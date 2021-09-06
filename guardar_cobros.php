<?php 
@session_start(); 
include('_conexion.php');
//Registrar cobros
$sql1="select max(idcobro) from cabcobros";
$datos1 = pg_query ($con, $sql1) or die ("Problemas en select:".pg_last_error ());
$idc=pg_fetch_array($datos1);
$nextid=$idc[0]+1;
$fecha=date('Y-m-d');

$insert_cab="insert into cabcobros (idcobro, nro, idcaja, fecha, idclie, ualta, falta, activo, efectivo, cheque, tarjeta, idsucursal, estado)
 values ('".$nextid."', '".$_POST['recibo']."', ".$_SESSION['login_idcaja'].", '".$fecha."', '".$_POST['idclie']."', ".$_SESSION['login_idusu'].", '".$fecha."', 1, '".$_POST['efectivo']."', '".$_POST['cheque']."', '".$_POST['tarjeta']."', ".$_SESSION['login_sucursal'].", 1)";
$datos = pg_query ($con, $insert_cab) or die ("Problemas en $-campos:".pg_last_error ());

$montot=$_POST['efectivo'] + $_POST['cheque'] + $_POST['tarjeta']; 

$insert_det="insert into detcobros (idcobro, idventa, monto, falta, interes) values ('".$nextid."', '".$_POST['idventa']."', '".$montot."', '".$fecha."', '".$_POST['interes']."')";
$datos = pg_query ($con, $insert_det) or die ("Problemas en $-campos:".pg_last_error ());

echo '<script>location.href="cobros.php?ok=1";</script>';
    
?>