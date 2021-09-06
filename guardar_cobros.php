<?php 
@session_start(); 
include('_conexion.php');
//Registrar cobros
$sql1="select max(idcobro) from cabcobros";
$datos1 = pg_query ($con, $sql1) or die ("Problemas en select:".pg_last_error ());
$idc=pg_fetch_array($datos1);
$nextid=$idc[0]+1;
$fecha=date('Y-m-d');

$insert_cab="insert into cabcobros (idcobro, nro, idcaja, fecha, idclie, ualta, falta, activo, efectivo, cheque, tarjeta, idsucursal, estado, anticip, ccaja, tipo, retnro, retfec, retmon)
 values ('".$nextid."', '".$_POST['recibo']."', ".$_SESSION['login_idcaja'].", '".$fecha."', '".$_POST['idclie']."', ".$_SESSION['login_idusu'].", '".$fecha."', 1, '".$_POST['efectivo']."', '".$_POST['cheque']."', '".$_POST['tarjeta']."', ".$_SESSION['login_sucursal'].", 1, 0, 0, '001".$_SESSION['login_nrocaja']."', '".$_POST['retencion_nro']."', '".$_POST['retencion_fecha']."', '".$_POST['retencion_monto']."')";
$datos = pg_query ($con, $insert_cab) or die ("Problemas en $-campos:".pg_last_error ());

$montot=$_POST['efectivo'] + $_POST['cheque'] + $_POST['tarjeta'] + $_POST['retencion_monto'];

if($_POST['cobrar_interes'] == 0){
    $_POST['interes_sin']=0;
}else{
    if($_POST['interes_sin'] == ''){$_POST['interes_sin']=0;}
    if($_POST['interes_sin'] > $montot){
        $_POST['interes_sin'] = $montot;
    }
}

$insert_det="insert into detcobros (idcobro, idventa, monto, falta, interes) values ('".$nextid."', '".$_POST['idventa']."', '".$montot."', '".$fecha."', ".$_POST['interes_sin'].")";
$datos = pg_query ($con, $insert_det) or die ("Problemas en $-campos:".pg_last_error ());

echo '<script>location.href="cobros.php?ok=1";</script>';
    
?>