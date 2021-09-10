<?php 
@session_start(); 
include('_conexion.php');
if($_GET['opcion']==1){
//Agregar facturas
    $sw=0;
    foreach ($_SESSION['lista_facturas'] as $v) {
        if($v == $_GET['nro']){$sw=1; break;}
    }
    if($sw == 0){
        array_push($_SESSION['lista_facturas'], $_GET['nro']);
    }
    //print_r($_SESSION['lista_facturas']);
   echo '<script>location.href="cobros.php?txt_cliente='.$_GET['txt_cliente'].'&txt_idclie='.$_GET['txt_idclie'].'";</script>';
}

if($_GET['opcion']==2){
    //Eliminar facturas
    $_SESSION['lista_facturas'] = array_diff($_SESSION['lista_facturas'], array($_GET['nro']));
    echo '<script>location.href="cobros.php?txt_cliente='.$_GET['txt_cliente'].'&txt_idclie='.$_GET['txt_idclie'].'";</script>';
}

if($_GET['opcion']==3){
//Registrar cobros

//next idcobro
$sql1="select max(idcobro) from cabcobros";
$datos1 = pg_query ($con, $sql1) or die ("Problemas en select:".pg_last_error ());
$idc=pg_fetch_array($datos1);
$nextid=$idc[0]+1;

//next nro recibo
$sql1="SELECT nrorec FROM nrosdoc where idsucursal=".$_SESSION['login_sucursal'];
$datos1 = pg_query ($con, $sql1) or die ("Problemas en select:".pg_last_error ());
$idc=pg_fetch_array($datos1);
$nextrec=$idc[0];

$fecha=date('Y-m-d');
if($_POST['retencion_fecha'] == ''){$_POST['retencion_fecha']='1900-01-01';}

$insert_cab="insert into cabcobros (idcobro, nro, idcaja, fecha, idclie, ualta, falta, activo, efectivo, cheque, tarjeta, idsucursal, estado, anticip, ccaja, tipo, retnro, retfec, retmon)
 values ('".$nextid."', '".$nextrec."', ".$_SESSION['login_idcaja'].", '".$fecha."', '".$_POST['txt_idclie']."', ".$_SESSION['login_idusu'].", '".$fecha."', 1, '".$_POST['efectivo']."', '".$_POST['cheque']."', '".$_POST['tarjeta']."', ".$_SESSION['login_sucursal'].", 1, 0, 0, '001".$_SESSION['login_nrocaja']."', '".$_POST['retencion_nro']."', '".$_POST['retencion_fecha']."', '".$_POST['retencion_monto']."')";
$datos = pg_query ($con, $insert_cab) or die ("Problemas en $-campos:".pg_last_error ());

//actualizar next recibo nro
$nextrec=$nextrec+1;
$rsql="update nrosdoc set nrorec=".$nextrec." where idsucursal=".$_SESSION['login_sucursal'];
$recibo = pg_query ($con, $rsql) or die ("Problemas en select:".pg_last_error ());

$montot=$_POST['efectivo'] + $_POST['cheque'] + $_POST['tarjeta'] + $_POST['retencion_monto'];

foreach($_SESSION['detcobros'] as $k => $detalle){ 

        $insert_det="insert into detcobros (idcobro, idventa, monto, falta, interes) values ('".$nextid."', '".$detalle['idventa']."', '".$detalle['pagar']."', '".$fecha."', 0)";
        $datos = pg_query ($con, $insert_det) or die ("Problemas en $-campos:".pg_last_error ());

        if($detalle['pagar'] == $detalle['saldo']){
            $ssql="update cabventas set saldado=1 where idventa=".$detalle['idventa'];
            $saldado = pg_query ($con, $ssql) or die ("Problemas en select:".pg_last_error ());
        }    
}
unset($_SESSION['detcobros']);
//echo '<script>location.href="cobros-cabecera.php?ok=1";</script>';
echo '<script>location.href="cobros-redir.php?id='.$nextid.'";</script>';
} 

?>