﻿<?php  //Configuracion de la conexion a base de datos
@session_start();
include('_conexion.php'); 

	$sqlcab="SELECT idclie, nro, falta, idcaja, efectivo, (cheque+chequead) as cheque, girost, depoban, tipo as punto FROM cabcobros WHERE idcobro=".$_GET["identificador"];
	$cab = pg_query ($con, $sqlcab) or die ("Problemas en $-campos cabecera:".pg_last_error ());
	$cb=pg_fetch_array($cab);
	
	$cf=strlen($cb['nro']);
	$fal=7-$cf;
	$nroini='';
	for ($i = 1; $i <= $fal; $i++) {
    	$nroini.='0';
	}

	$sqlclie="SELECT nombres, ruc FROM clientes WHERE idclie=". $cb['idclie'];
	$clie = pg_query ($con, $sqlclie) or die ("Problemas en $-campos clie:".pg_last_error ());
	$cl=pg_fetch_array($clie);

	switch ($_SESSION['login_idusu']) {
		case 45:
			$actividad_secundaria='Comercio al por mayor de materiales de construccion';
			$nombre_negocio = 'DUN DUN';
			$nombre_negocio_l2 = 'Paraguay';
			$telefono = 'Tel.: 0981 232 217 - 0981 180 469';
			$instagram='Instagram: @dundun_paraguay';
			break;
		default:
			$actividad_secundaria='Comercio al por mayor de tabaco y cigarrillos';
			$nombre_negocio = 'COMPER';
			$nombre_negocio_l2 = '';
			$telefono = 'Tel.: 0982 185 359 - 0984 289 831 - 0981 180 469';
			$instagram='';
			break;

	}
?>
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
<SCRIPT language="javascript">
function imprimir(){ 
	if ((navigator.appName == "Netscape")) { window.print() ;}
	else{ 
		var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
		document.body.insertAdjacentHTML('beforeEnd', WebBrowser); WebBrowser1.ExecWB(6, -1); WebBrowser1.outerHTML = "";
	}
}
</SCRIPT>
</HEAD>
<body onLoad="imprimir();">
<div id="con_gral" style="font-size:10px; font-family:Arial;  ">
<table width="100%">
	<tr>
		<td colspan="4" width="176" style="text-align:center; font-size:22px; font-family:Arial;"><strong><?php echo $nombre_negocio; ?></strong></td>
    </tr>
	<tr>
		<td colspan="4" width="176" style="text-align:center; font-size:22px; font-family:Arial;"><strong><?php echo $nombre_negocio_l2; ?></strong></td>
    </tr>
	<tr>
    	<td colspan="4" style="font-size:9px; text-align:center;">de Victor G. Perez Velázquez </td>
    </tr>
	<tr>
    	<td colspan="4" style="font-size:9px; text-align:center; ">Comercio al por menor de otros productos en comercio no especializados </td>
    </tr>
	<tr>
    	<td colspan="4" style="font-size:9px; text-align:center; ">Comercio al por mayor de tabaco y cigarrillos</td>
    </tr>
	<tr>
    	<td colspan="4" style="font-size:9px; text-align:center; ">
		
			<?php echo $actividad_secundaria; ?>

		</td>
    </tr>
    <tr>
    	<td colspan="5" style="font-size:9px; text-align:center;">C.Matriz: Julia Miranda Cueto e/ Ayala Candia - Fndo. de la Mora</td>
    </tr>
    <tr>
    	<td colspan="4" style="font-size:9px; text-align:center;"><?php echo $telefono; ?></td>
    </tr>
    <tr>
    	<td colspan="4" style="font-size:9px; text-align:center;"><?php echo $instagram; ?></td>
    </tr>
    <tr>
    	<td colspan="4" style="font-size:9px; text-align:center;">RUC: 2238812-5</td>
    </tr>
    <tr>
    	<td colspan="4" style="font-size:9px; text-align:center;">Fecha de Emision: <?php echo date("d-m-Y", strtotime($cb['falta']))?></td>
    </tr>
    <tr>
    	<td colspan="4" style="font-size:9px; text-align:center;">Recibo de dinero
            
        N°:<?php echo $cb['punto'] ?>-<?php echo $nroini.$cb["nro"] ?></td>
    </tr>
	<tr>
    	<th width="176" style="text-align:right;">Fact. N°</th>
    	<th width="176" style="text-align:right;">Monto Pago</th>
    </tr>
	<?php 
	$tot=0;
	$sqldet="SELECT punto, nrofac, monto FROM vi_detcobros WHERE idcobro=".$_GET['identificador'];
	$det = pg_query ($con, $sqldet) or die ("Problemas en $-campos detalle1:".pg_last_error ());
	$total_cobro=0;
	while($dt=pg_fetch_array($det)){
		$total_cobro=$total_cobro+$dt['monto'];
		?>
			<tr>
				<td width="176"  style="text-align:right;"><?php echo $dt['punto']."-".$dt['nrofac'];?></td>
				<td width="176"  style="text-align:right;"><?php echo number_format($dt['monto'], 0, ',', '.'); ?></td>
			</tr>	
		<?php 
	}
 ?> 
	<tr>
    	<td colspan="4" width="176" style="text-align:left; font-size:14px; font-family:Arial;"><strong>Total:</strong> <?php echo  number_format($total_cobro, 0, ',', '.') ?></td>
    </tr>
 	<tr>
    	<td colspan="4" style="text-align:left; font-size:12px; height:26px;">&nbsp;</td>
    </tr>
	<tr>
    	<th colspan="4" style="text-align:left; font-size:12px; height:26px;"><strong>-- Datos del Cliente--</th>
    </tr>
	<tr>
    	<td colspan="4" style="text-align:left; font-size:12px; height:26px;">Razon Social: <?php echo $cl['nombres'] ?></td>
    </tr>
	<tr>
    	<td colspan="4" style="text-align:left; font-size:12px; height:26px;">RUC/CI: <?php echo $cl['ruc'] ?></td>
    </tr>
   	<tr>
    	<td colspan="4" style="text-align:center; font-size:14px; height:26px;">*Gracias por su pago*</td>
    </tr>

</table>
</div>
</BODY>
</HTML>
<script type="text/javascript">
function redireccionarPagina() {
	window.location = "cobros-cabecera.php?ok=1";
}
//setTimeout("redireccionarPagina()", 800);
//echo '<script>location.href="cobros-cabecera.php?ok=1";</script>';
</script>