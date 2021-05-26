<?php
session_start();
/*
//Configuracion de la conexion a base de datos
$bd_host      = 'localhost'; 
$bd_usuario   = 'postgres'; 
$bd_password  = 'vradmin'; 
$bd_base      = '4b'; 

$conn_string = "host=".$bd_host." port=5432 dbname=".$bd_base." user=".$bd_usuario." password=".$bd_password;
$con = pg_connect($conn_string); 

//		if ($_POST['tot']!='' && $_POST['tot'] > 0) {
			
			$cnro =pg_query ($con, "SELECT max(fac_nro) FROM cab_ventas WHERE id_caja=".$_POST['txt_caja']) or die ("Problemas en $-campos:".pg_last_error ());
			$rn=pg_fetch_array($cnro);
			$nnro=$rn[0];
			$nro= $nnro+1;

			$cclie = pg_query ($con, "SELECT clie_id FROM clientes WHERE clie_ruc='".$_POST['txt_ruc']."'") or die ("Problemas en $-campos:".pg_last_error ());
			$nrows=pg_num_rows($cclie);
			if($nrows > 0){
				$rc=pg_fetch_array($cclie);
				$clie=$rc["clie_id"];
			}else{
				$insertclie="INSERT INTO clientes (clie_nombre, clie_ruc) VALUES ('".$_POST['txt_nombre']."', '".$_POST['txt_ruc']."')";
				$cliein = pg_query ($con, $insertclie) or die ("Problemas en $-campos: Insert Cliente".pg_last_error ());
				$cclie = pg_query ($con, "SELECT clie_id FROM clientes WHERE clie_ruc='".$_POST['txt_ruc']."'") or die ("Problemas en $-campos:".pg_last_error ());
				$rc=pg_fetch_array($cclie);
				$clie=$rc["clie_id"];
				}
			
			$csucu = pg_query ($con, "SELECT sucu_id FROM depositos WHERE depo_id='".$_POST['txt_deposito']."'") or die ("Problemas en $-campos:".pg_last_error ());
			$rs=pg_fetch_array($csucu);
			$sucu=$rs["sucu_id"];

			$csucunro = pg_query ($con, "SELECT sucu_nro FROM sucursal WHERE sucu_id=".$sucu) or die ("Problemas en $-campos:".pg_last_error ());
			$rsn=pg_fetch_array($csucu);
			$sucunro=$rsn["sucu_id"];

			$fni=$sucunro.$_POST['txt_caja'];
			
			if (($_POST['txt_efectivo'] == '') or ($_POST['txt_efectivo'] == 0)){ $_POST['txt_efectivo'] = $_POST['txt_tot'];}
			$fecha=date('Y-m-d');
			
			if ($_POST['txt_tc'] == ''){ $_POST['txt_tc'] = 0;}
			if ($_POST['txt_td'] == ''){ $_POST['txt_td'] = 0;}
			
	$sqlinsert='INSERT INTO cab_ventas (fac_nro, clie_id, tipo_ventas, total_gravada, tipo_moneda, deposito, efectivo, tc, td, id_caja, id_vend, fac_nro_ini) VALUES ('.$nro.', '.$clie.', 1, '.$_POST['txt_tot'].', 1, '.$_POST['txt_deposito'].', '.$_POST['txt_efectivo'].', '.$_POST['txt_tc'].', '.$_POST['txt_td'].', '.$_POST['txt_caja'].', '.$_POST['txt_vend'].', '.$fni.' )';
	
	$insert = pg_query ($con, $sqlinsert) or die ("Problemas en $-campos:".pg_last_error ());

foreach($_SESSION['detalle'] as $k => $detalle){ 
	$tot_det=$detalle['cantidad']*$detalle['precio'];
	$sqlinsertdet="INSERT INTO det_ventas (fac_nro, fac_fecha, art_id, cantidad, punitario, gravada, total) 
	VALUES(".$nro.", '".$fecha."', ".$detalle["idart"].", ".$detalle["cantidad"].", ".$detalle["precio"].", ".$tot_det.", ".$tot_det." )";

	$insertdet = pg_query ($con, $sqlinsertdet) or die ("Problemas en $-campos:".pg_last_error ());
}
	
	unset($_SESSION['detalle']);
*/	
	echo  '<script>location.parent.href="../index.php";</script>';
	
	//}fin de condicion de total
		
?>