<?php  //Configuracion de la conexion a base de datos
@session_start();
include('_conexion.php'); 

	$sqlcab="SELECT idclie, nro, falta, idcaja, tipofac, idventa, exentas, grav5, grav10, iva5, iva10, idvend, vence FROM cabventas WHERE idventa=".$_GET["identificador"];
	$cab = pg_query ($con, $sqlcab) or die ("Problemas en $-campos cabecera:".pg_last_error ());
	$cb=pg_fetch_array($cab);
	
	$tipofac=$cb['tipofac'];
	$cf=strlen($cb['nro']);
	$fal=7-$cf;
	$nroini='';
	for ($i = 1; $i <= $fal; $i++) {
    	$nroini.='0';
	}

	$sql2="SELECT a.nrocaja, b.nro_timbrado as timbrado, b.fecini as inicio, b.fecven as validez, a.idsucursal FROM cajas a inner join timbrados b on a.idcaja=b.idcaja WHERE b.idcaja=".$_SESSION['login_idcaja'].' and b.activo=1 and b.tipo_doc=1';
	$cons2=pg_query($con, $sql2)or die ("Problemas en consulta ".pg_last_error ());
	$nca=pg_fetch_array($cons2);

	$sql3="SELECT nrosuc FROM sucursal WHERE idsucursal=".$nca['idsucursal'];
	$cons3=pg_query($con, $sql3)or die ("Problemas en consulta ".pg_last_error ());
	$suc=pg_fetch_array($cons3);

	$sqlclie="SELECT a.nombres, ruc, direccion, telefono, b.nombres as ciudad FROM clientes a inner join ciudad b on a.idciudad=b.idciudad WHERE a.idclie=". $cb['idclie'];
	$clie = pg_query ($con, $sqlclie) or die ("Problemas en $-campos clie:".pg_last_error ());
	$cl=pg_fetch_array($clie);

	$sqlvende="SELECT nombres FROM vendedores WHERE idvend=". $cb['idvend'];
	$vende = pg_query ($con, $sqlvende) or die ("Problemas en $-campos vende:".pg_last_error ());
	$ve=pg_fetch_array($vende);

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
    	<td colspan="4" style="font-size:9px; text-align:center; ">Comercio al por mayor de otros productos N.C.P. </td>
    </tr>
	<tr>
    	<td colspan="4" style="font-size:9px; text-align:center; ">Comercio al por menor de otros productos en comercio no especializados </td>
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
    	<td colspan="4" style="font-size:9px; text-align:center;">Timbrado:<?php echo $nca['timbrado'] ?></td>
    </tr>
    <tr>
    	<td colspan="4" style="font-size:9px; text-align:center;">Inicio:<?php echo date("d-m-Y", strtotime($nca['inicio'])) ?> Vencimiento:<?php echo date("d-m-Y", strtotime($nca['validez'])) ?></td>
    </tr>
    <tr>
    	<td colspan="4" style="font-size:9px; text-align:center;">Fecha de Emisión: <?php echo date("d-m-Y", strtotime($cb['falta']))?></td>
    </tr>
	<?php
		if($tipofac==2){
		echo '
		<tr>
    		<td colspan="4" style="font-size:9px; text-align:center;">Fecha de Vencimiento: '. date("d-m-Y", strtotime($cb['vence'])).'</td>
		</tr>';
	}?>
    <tr>
    	<td colspan="4" style="font-size:9px; text-align:center;">Factura <?php if ($cb['tipofac'] == 1) { echo "Contado";}else{ echo "Credito";} ?>
            
          N°:<?php echo $suc[0] ?>-<?php echo $nca[0] ?>-<?php echo $nroini.$cb["nro"] ?></td>
    </tr>
	<tr>
    	<th width="38" style="font-size:12px";>Cant.</th>
    	<th width="176" style="font-size:12px">Articulo</th>
    	<th width="176" style="font-size:12px">Precio</th>
    	<th width="176" style="font-size:12px">Total</th>
    </tr>
	<?php 
	$tot=0;
	$sqldet="SELECT idart, cant, (precio*1.1) as precio FROM detventas WHERE idventa=".$_GET['identificador'];
	$det = pg_query ($con, $sqldet) or die ("Problemas en $-campos detalle1:".pg_last_error ());
	
	while($dt=pg_fetch_array($det)){
	
	$sqlart="SELECT nombres FROM articulos WHERE idart=". $dt['idart'];
	$arti = pg_query ($con, $sqlart) or die ("Problemas en $-campos detalle art:".pg_last_error ());
	$at=pg_fetch_array($arti);
	$art=$at['nombres'];

	$tot1=$dt['cant']*$dt['precio'];
	$tot=$tot+$tot1;
	?>
	<tr>
    	<td width="38" style="font-size:11px"><?php echo number_format($dt['cant'], 0, ',', '.'); ?></td>
    	<td colspan="3" style="font-size:11px" width="400"><?php echo $art; ?></td>
	</tr>
	<tr>
		<td width="38" style="font-size:11px"></td>
		<td width="38" style="font-size:11px"></td>
    	<td width="38" style="font-size:11px"><?php echo number_format($dt['precio'], 0, ',', '.'); ?></td>
    	<td width="38" style="font-size:11px"><?php echo number_format($tot1, 0, ',', '.'); ?></td>
    </tr>
    
 <?php 
 }
	$totiva=$cb['iva10']+$cb['iva5'];
 ?> 
	<tr>
    	<td colspan="4" width="176" style="text-align:left; font-size:14px; font-family:Arial;"><strong>Total:</strong> <?php echo  number_format($tot, 0, ',', '.') ?></td>
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
    	<td colspan="4" style="text-align:left; font-size:12px; height:26px;">Telefono: <?php echo $cl['telefono'] ?></td>
    </tr>  
	<tr>
    	<td colspan="4" style="text-align:left; font-size:12px; height:26px;">Direccion: <?php echo $cl['direccion'] ?></td>
    </tr>
	<tr>
    	<td colspan="4" style="text-align:left; font-size:12px; height:26px;">Ciudad: <?php echo $cl['ciudad'] ?></td>
    </tr>
	<tr>
    	<td colspan="4" style="text-align:left; font-size:12px; height:26px;">Vendedor: <?php echo $ve['nombres'] ?></td>
    </tr>
	<tr>
    	<td colspan="4" style="text-align:left; font-size:12px; height:26px;"><strong>-- Liquidacion de IVA --</td>
    </tr>
	<tr>
    	<td colspan="4" style="text-align:left; font-size:12px; height:26px;">10%:<?php echo round($cb['iva10']); ?></td>
    </tr>
	<tr>
    	<td colspan="4" style="text-align:left; font-size:12px; height:26px;">5%:<?php echo round($cb['iva5']); ?></td>
    </tr>
	<tr>
    	<td colspan="4" style="text-align:left; font-size:12px; font-size:12px; height:26px;"><strong>Total IVA:<?php echo round($totiva); ?></td>
    </tr>
 	<tr>
    	<td colspan="4" style="text-align:left; font-size:12px; height:26px;">&nbsp;</td>
    </tr>
    </tr>
	<?php
		if($tipofac==2){
		echo '
		<tr>
			<td colspan="4" style="font-size:9px; text-align:center; height:26px;">Esta factura deberá ser cancelada dentro del plazo establecido, de no ser asi aplicara el 3% de interes mensual. Los autorizo incluyan mi nombre o la razón social que represento en el registro general de morosos de inforconf o el de otra entidad especializada en el mismo, y proporcionar dicha información a terceras personas</td>
		</tr>';
	}?>
 	<tr>
    	<td colspan="4" style="text-align:center; height:26px;">*Gracias por su preferencia*</td>
    </tr>

</table>
</div>
<!-- DUPLICADO -->
<?php 
if($tipofac==2){
	echo '
<div id="con_gral" style="font-size:10px; font-family:Arial;  ">
<table width="100%">
	<tr>
    	<td colspan="4" style="text-align:center;">'.$nombre_negocio.'</td>
    </tr>
	<tr>
    	<td colspan="4" style="text-align:center;">'.$nombre_negocio_l2.'</td>
    </tr>
	<tr>
    	<td colspan="4" style="font-size:9px; text-align:center;">de Victor G. Perez Velázquez </td>
    </tr>
	<tr>
    	<td colspan="4" style="font-size:9px; text-align:center; ">Comercio al por menor de otros productos en comercio no especializados </td>
    </tr>
	<tr>
    	<td colspan="4" style="font-size:9px; text-align:center; ">
		
			'.$actividad_secundaria.'
	
		</td>
    </tr>
    <tr>
    	<td colspan="5" style="font-size:9px; text-align:center;">C.Matriz: Julia Miranda Cueto e/ Ayala Candia - Fndo. de la Mora</td>
    </tr>
    <tr>
    	<td colspan="4" style="font-size:9px; text-align:center;">'.$telefono.'</td>
    </tr>
    <tr>
    	<td colspan="4" style="font-size:9px; text-align:center;">'.$instagram.'</td>
    </tr>
    <tr>
    	<td colspan="4" style="font-size:9px; text-align:center;">RUC: 2238812-5</td>
    </tr>
    <tr>
		<td colspan="4" style="font-size:9px; text-align:center;">Timbrado:'.$nca['timbrado'].'</td>
	</tr>
    <tr>
    	<td colspan="4" style="font-size:9px; text-align:center;">Inicio:'.date("d-m-Y", strtotime($nca['inicio'])).' Vencimiento:'.date("d-m-Y", strtotime($nca['validez'])).'</td>
    </tr>
    <tr>
    	<td colspan="4" style="font-size:9px; text-align:center;">Fecha de Emision: '.date("d-m-Y", strtotime($cb['falta'])).'</td>
    </tr>
    <tr>
    	<td colspan="4" style="font-size:9px; text-align:center;">Fecha de Vencimiento: '.date("d-m-Y", strtotime($cb['vence'])).'</td>
    </tr>
    <tr>
    	<td colspan="4" style="font-size:9px; text-align:center;">Factura Crédito
            
          N°:'.$suc[0]. '-' . $nca[0] .'-'. $nroini.$cb["nro"] .'</td>
    </tr>
	<tr>
    	<th width="38" style="font-size:12px">Cant.</th>
    	<th width="176" style="font-size:12px">Articulo</th>
    	<th width="176" style="font-size:12px">Precio</th>
    	<th width="176" style="font-size:12px">Total</th>
    </tr>';
	$tot=0;
	$sqldet="SELECT idart, cant, (precio*1.1) as precio FROM detventas WHERE idventa=".$_GET['identificador'];
	$det = pg_query ($con, $sqldet) or die ("Problemas en $-campos detalle1:".pg_last_error ());
	
	while($dt=pg_fetch_array($det)){
	
	$sqlart="SELECT nombres FROM articulos WHERE idart=". $dt['idart'];
	$arti = pg_query ($con, $sqlart) or die ("Problemas en $-campos detalle art:".pg_last_error ());
	$at=pg_fetch_array($arti);
	$art=$at['nombres'];

	$tot1=$dt['cant']*$dt['precio'];
	$tot=$tot+$tot1;
	echo
	'
	<tr>
    	<td width="38" style="font-size:9px">'.number_format($dt["cant"], 0, ",", ".").'</td>
    	<td colspan="3" width="400" style="font-size:9px">'.$art.'</td>
	</tr>
	<tr>
		<td width="38" style="font-size:11px"></td>
		<td width="38" style="font-size:11px"></td>
    	<td width="38" style="font-size:11px">'. number_format($dt['precio'], 0, ',', '.').'</td>
    	<td width="38" style="font-size:11px">'. number_format($tot1, 0, ',', '.') .'</td>
    </tr>';
}
	$totiva=$cb['iva10']+$cb['iva5'];
 echo 
 '
	<tr>
    	<td colspan="4" width="176" style="text-align:left; font-size:14px; font-family:Arial;"><strong>Total:</strong> '. number_format($tot, 0, ',', '.') .'</td>
    </tr>
 	<tr>
    	<td colspan="4" style="text-align:left; font-size:12px; height:26px;">&nbsp;</td>
    </tr>
	<tr>
    	<th colspan="4" style="text-align:left; font-size:12px; height:26px;"><strong>-- Datos del Cliente--</th>
    </tr>
	<tr>
    	<td colspan="4" style="text-align:left; font-size:12px; height:26px;">Razon Social: '. $cl['nombres'] .'</td>
    </tr>
	<tr>
    	<td colspan="4" style="text-align:left; font-size:12px; height:26px;">RUC/CI: '.$cl['ruc'] .'</td>
    </tr>
	<tr>
    	<td colspan="4" style="text-align:left; font-size:12px; height:26px;">Telefono: '.$cl['telefono'].'</td>
    </tr>  
	<tr>
    	<td colspan="4" style="text-align:left; font-size:12px; height:26px;">Direccion: '.$cl['direccion'].'</td>
    </tr>
	<tr>
    	<td colspan="4" style="text-align:left; font-size:12px; height:26px;">Ciudad: '.$cl['ciudad'].'</td>
    </tr>
	<tr>
		<td colspan="4" style="text-align:left; font-size:12px; height:26px;">Vendedor: '.$ve['nombres'] .'</td>
	</tr>
	<tr>
    	<td colspan="4" style="text-align:left; font-size:12px; height:26px;"><strong>-- Liquidacion de IVA --</td>
    </tr>
	<tr>
    	<td colspan="4" style="text-align:left; font-size:12px; height:26px;">10%:'.round($cb['iva10']).'</td>
    </tr>
	<tr>
    	<td colspan="4" style="text-align:left; font-size:12px; height:26px;">5%:'. round($cb['iva5']).'</td>
    </tr>
	<tr>
    	<td colspan="4" style="text-align:left; font-size:12px; height:26px;"><strong>Total IVA:'. round($totiva).'</td>
    </tr>
 	<tr>
    	<td colspan="4" style="text-align:left; font-size:12px; height:26px;">&nbsp;</td>
    </tr>
	<tr>
		<td colspan="4" style="font-size:9px; text-align:center; height:26px;">Esta factura deberá ser cancelada dentro del plazo establecido, de no ser asi aplicara el 3% de interes mensual. Los autorizo incluyan mi nombre o la razón social que represento en el registro general de morosos de inforconf o el de otra entidad especializada en el mismo, y proporcionar dicha información a terceras personas</td>
	</tr>
 	<tr>
    	<td colspan="4" style="text-align:center; height:26px;">*Gracias por su preferencia*</td>
    </tr>


</table>
</div>
<!-- FIN DUPLICADO -->
';
}?>
</BODY>
</HTML>
<script type="text/javascript">
function redireccionarPagina() {
	window.location = "cabecera.php";
}
//setTimeout("redireccionarPagina()", 800);
</script>