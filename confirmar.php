<?php
@session_start();
include('_conexion.php');

	$fecha=date('Y-m-d H:i:s');
	$totgral=0;
	$totiva5=0;
	$totiva10=0;
	$totgrav10=0;
	$totgrav5=0;
	$sum10=0;
	$sum5=0;
   	foreach($_SESSION['detalle'] as $k => $detalle){
		$totgral=$totgral+$detalle['total'];
	}

$_POST['txt_tot']=$totgral - $_POST['txt_desc'];

	if(($_POST['txt_ingresa']==0) or ($_POST['txt_ingresa']=='')){
		$_POST['txt_efectivo'] = 0;
	}else{
			$_POST['txt_efectivo'] = $_POST['txt_ingresa'];
	}

	$_POST['txt_tc'] = 0;
	$_POST['txt_td'] = 0;

	$tot_pago=$_POST['txt_tc'] + $_POST['txt_td'] + $_POST['txt_efectivo'];


	if (($_POST['txt_tc'] == 0) and ($_POST['txt_td'] == 0)) { $_POST['txt_efectivo'] = $_POST['txt_tot'];}


	if ($_POST['txt_tot']!='' and $_POST['txt_tot'] > 0) {

		if(($_POST['txt_caja'] == null) or ($_POST['txt_caja'] == '') or (empty($_POST['txt_caja']))){
			echo '<script>location.href="index.php";</script>';
		}

		$cnro =pg_query ($con, "SELECT max(nro) FROM cabventas WHERE idcaja=".$_SESSION['login_idcaja']) or die ("Problemas en $-campos:".pg_last_error ());
		$rn=pg_fetch_array($cnro);
		$nnro=$rn[0];
		$nro= $nnro+1;
		$cnro =pg_query ($con, "SELECT max(idventa) FROM cabventas") or die ("Problemas en $-campos:".pg_last_error ());
		$rn=pg_fetch_array($cnro);
		$idventa=$rn[0]+1;



/*clientes*/
			if($_POST['txt_idclie'] == ''){
				if($_POST['txt_nombre'] == ''){
					$clie=0;					
				}else{
					$insertClie="INSERT INTO clientes (nombres, ruc) VALUES ('".$_POST['txt_nombre']."', '".$_POST['txt_ruc']."')";
					pg_query ($con, $insertClie) or die ("Problemas en insert cliente:".pg_last_error ());
					$queryClie =pg_query ($con, "SELECT max(idclie) FROM clientes") or die ("Problemas en $-campos:".pg_last_error ());
					$dt=pg_fetch_array($queryClie);
					$clie=$dt[0];
				}
			}else{
				$clie=$_POST['txt_idclie'];
			}
/*clientes*/

$iva10=round($_POST["txt_tot"]/11);
$gravada10=$_POST["txt_tot"]-$iva10;
$pla=' +'.$_POST['plazo'].' day ';
$hoy=date('Y-m-d');
$varf=$hoy.$pla;
$nuevafecha = date('Y-m-d', strtotime($varf));

$sqlinsert="INSERT INTO cabventas (idventa, idclie, idvend , timb, nro, idcaja, efectivo, cheque, tarjeta, chequead, girost, depoban, idsucursal, ualta, falta, activo, tipofac, vence, exentas, grav5, grav10, iva5, iva10, tipvta, timbrado, estado) VALUES (".$idventa.", ".$clie.", ".$_SESSION['login_vendedor'].", ".$_SESSION['login_timb'].", ".$nro.", ".$_SESSION['login_idcaja'].", ".$_POST["efectivo"].", ".$_POST["cheque"].", ".$_POST["tarjeta"].", ".$_POST["chequead"].", ".$_POST["giros"].", ".$_POST["depositoban"].", ".$_SESSION['login_sucursal'].", ".$_SESSION['login_idusu'].", '".$fecha."', 1, ".$_POST['tipovta'].", '".$nuevafecha."', 0, 0, ".$gravada10.", 0, ".$iva10.", ".$_SESSION['login_deposito'].", ".$_SESSION['login_timbrado'].", 1)";
	$insertcab = pg_query ($con, $sqlinsert) or die ("Problemas en cabecera:".pg_last_error ());

$sqlart="SELECT ultcosto FROM articulos WHERE idart=".$detalle["idart"];
$datart = pg_query ($con, $sqlart) or die ("Problemas en $-campos ultcosto articulos:".pg_last_error ());
$uc=pg_fetch_array($datart);

/*trackart*/
$sqlclie="SELECT nombres FROM clientes WHERE idclie=". $clie;
$dataclie = pg_query ($con, $sqlclie) or die ("Problemas en $-campos clie:".pg_last_error ());
$cl=pg_fetch_array($dataclie);

/*$tnro =pg_query ($con, "SELECT max(idtrack) FROM trackart") or die ("Problemas en $-campos:".pg_last_error ());
$tn=pg_fetch_array($tnro);
$tnro= $tn[0]+1;*/

$descrip = 'VENTA FACTURA Nº '.$nro.' CLIENTE: '.$cl[0];
/*trackart*/

foreach($_SESSION['detalle'] as $k => $detalle){
	$tot_det=$detalle['cantidad']*$detalle['precio'];
	$sqlinsertdet="INSERT INTO detventas (idventa, idart, cant, precio, falta, ivanum, idunidad, idunidad2, basimp, descu, cant2, prdesc, costo)
	VALUES(".$idventa.", '".$detalle["idart"]."', ".$detalle["cantidad"].", ".$detalle["precio"].", '".$fecha."', '10', '0', '0', '100', '0', ".$detalle["cantidad"].", ".$detalle["precio"].", ".$uc["ultcosto"].")";

	$insertdet = pg_query ($con, $sqlinsertdet) or die ("Problemas en detalle:".pg_last_error ());
	
	/*stock*/
		$sqldep="SELECT cant FROM detstock WHERE idart=".$detalle["idart"]." and iddeposito=".$_SESSION['login_deposito'];
		$condep = pg_query ($con, $sqldep) or die ("Problemas en $-campos deposito1 stock:".pg_last_error ());
		$drows=pg_num_rows($condep);
		if($drows > 0){
			$dp=pg_fetch_array($condep);
			$cant=$dp["cant"];
			$cantact=$cant - $detalle["cantidad"];

			$sqlup="UPDATE detstock SET cant=".$cantact." WHERE idart=".$detalle["idart"]." and iddeposito=".$_SESSION['login_deposito'];
			$updatestk = pg_query ($con, $sqlup) or die ("Problemas en $-campos deposito2 stock:".pg_last_error ());
		}else{
			$cant=0;
			$cantact=$cant - $detalle["cantidad"];
			$sqlin="INSERT INTO detstock (idart, cant, iddeposito) VALUES (".$detalle["idart"].", ".$cantact.", ".$_SESSION['login_deposito'].")";
			$insertstk = pg_query ($con, $sqlin) or die ("Problemas en $-campos deposito 3 stock:".pg_last_error ());
		}
	/*stock*/

	/*trackart*/
	$tnro =pg_query ($con, "SELECT max(idtrack) FROM trackart") or die ("Problemas en $-campos:".pg_last_error ());
	$tn=pg_fetch_array($tnro);
	$tnro= $tn[0]+1;
	
	$sqltrack = "INSERT INTO trackart (idtrack, idart, idtipo, idoc, ualta, stk, entrada, salida, saldo, descrip, falta, iddeposito, usuario) VALUES
	 (".$tnro.", ".$detalle["idart"].", 2, ".$idventa.", ".$_SESSION['login_idusu'].", ".$cant.", 0, ".$detalle["cantidad"].", ".$cantact.", '".$descrip."', '".$fecha."', ".$_SESSION['login_deposito'].", ".$_SESSION['login_idusu'].")";
	 $inserttrack = pg_query ($con, $sqltrack) or die ("Problemas en $-campos insert trackart:".pg_last_error ());
	
	/*trackart*/

} /*fin de forech detalle*/

unset($_SESSION['detalle']);
echo '<script>location.href="redir.php?id='.$idventa.'";</script>';
}// fin del if de total

?>
