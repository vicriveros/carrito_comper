<?php  //Configuracion de la conexion a base de datos
@session_start();
include('_conexion.php'); 

	$sqlcab="SELECT idclie, nro, falta, idcaja, tipofac, idventa, exentas, grav5, grav10, iva5, iva10 FROM cabventas WHERE idventa=".$_GET["identificador"]." and idcaja=".$_SESSION['login_idcaja'];
	$cab = pg_query ($con, $sqlcab) or die ("Problemas en $-campos cabecera:".pg_last_error ());
	$cb=pg_fetch_array($cab);

	$cf=strlen($cb['nro']);
	$fal=7-$cf;
	$nroini='';
	for ($i = 1; $i <= $fal; $i++) {
    	$nroini.='0';
	}

	$sql2="SELECT nrocaja, timbrado, validez, idsucursal, inicio FROM cajas WHERE idcaja=".$_SESSION['login_idcaja'];
	$cons2=pg_query($con, $sql2)or die ("Problemas en consulta ".pg_last_error ());
	$nca=pg_fetch_array($cons2);

	$sql3="SELECT nrosuc FROM sucursal WHERE idsucursal=".$nca['idsucursal'];
	$cons3=pg_query($con, $sql3)or die ("Problemas en consulta ".pg_last_error ());
	$suc=pg_fetch_array($cons3);

	$sqlclie="SELECT nombres, ruc FROM clientes WHERE idclie=". $cb['idclie'];
	$clie = pg_query ($con, $sqlclie) or die ("Problemas en $-campos clie:".pg_last_error ());
	$cl=pg_fetch_array($clie);

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
<BODY onLoad="imprimir();">
<div id="con_gral" style="font-size:10px; font-family:Arial;  ">
<table width="288px">
	<tr>
    	<td colspan="3" style="text-align:center;">4B S.A.</td>
    </tr>
    <tr>
    	<td colspan="3" style="text-align:center;">Ruta Gral. Aquino N°3, Km 22.5 - Abasto Norte, Bloque C1, Local 09 </td>
    </tr>
    <tr>
    	<td colspan="3" style="text-align:center;">Ruc:80091477-5</td>
    </tr>
    <tr>
    	<td colspan="3" style="text-align:center;">Timbrado:<?php echo $nca['timbrado'] ?></td>
    </tr>
    <tr>
    	<td colspan="3" style="text-align:center;">Inicio:<?php echo date("d-m-Y", strtotime($nca['inicio'])) ?></td>
    </tr>
    <tr>
    	<td colspan="3" style="text-align:center;">Vencimiento:<?php echo date("d-m-Y", strtotime($nca['validez'])) ?></td>
    </tr>
    <tr>
    	<td colspan="3" style="text-align:center;">Telefono:021 207 167</td>
    </tr>
    <tr>
    	<td colspan="3" style="text-align:center;">Fecha de Emision:  <br><?php echo date("d-m-Y", strtotime($cb['falta']))?></td>
    </tr>
    <tr>
    	<td colspan="3" style="text-align:center;">Factura <?php if ($cb['tipofac'] == 1) { echo "Contado";}else{ echo "Credito";} ?>
            
          N°:</br> <?php echo $suc[0] ?>-<?php echo $nca[0] ?>-<?php echo $nroini.$cb["nro"] ?></td>
    </tr>

	<tr>
    	<td colspan="3" style="text-align:center; height:26px;">-- Detalle --</td>
    </tr>

	<tr>
    	<td colspan="3" style="text-align:left; height:26px;">&nbsp;</td>
    </tr>

	<tr>
    	<th width="38">Cant.</th>
    	<th width="176">Articulo</th>
    	<th width="176">Precio</th>
    	<th width="176">Total</th>
    </tr>
<?php 
$tot=0;
	$sqldet="SELECT idart, cant, precio FROM detventas WHERE idventa=".$_GET['identificador'];
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
    	<td width="38"><?php echo number_format($dt['cant'], 0, ',', '.'); ?></td>
    	<td width="176"><?php echo $art; ?></td>
    	<td width="38"><?php echo number_format($dt['precio'], 0, ',', '.'); ?></td>
    	<td width="38"><?php echo number_format($tot1, 0, ',', '.'); ?></td>
    </tr>
    
 <?php 
 }
$totiva=$cb['iva10']+$cb['iva5'];
 ?> 
	<tr>
    	<td colspan="3" width="176" style="text-align:left; font-size:22px; font-family:Arial;"><strong>Total:</strong> <?php echo  number_format($tot, 0, ',', '.') ?></td>
    </tr>

 	<tr>
    	<td colspan="3" style="text-align:left; height:26px;">&nbsp;</td>
    </tr>
	<tr>
    	<th colspan="3" style="text-align:left; height:26px;"><strong>-- Datos del Cliente--</th>
    </tr>
	<tr>
    	<td colspan="3" style="text-align:left; height:26px;">Razon Social: <?php echo $cl['nombres'] ?></td>
    </tr>
	<tr>
    	<td colspan="3" style="text-align:left; height:26px;">RUC/CI: <?php echo $cl['ruc'] ?></td>
    </tr>
  
	<tr>
    	<td colspan="3" style="text-align:left; height:26px;"><strong>-- Liquidacion de IVA --</td>
    </tr>
	<tr>
    	<td colspan="3" style="text-align:left; height:26px;">Exenta: 0</td>
    </tr>
	<tr>
    	<td colspan="3" style="text-align:left; height:26px;">10%:<?php echo round($cb['iva10']); ?></td>
    </tr>
	<tr>
    	<td colspan="3" style="text-align:left; height:26px;">5%:<?php echo round($cb['iva5']); ?></td>
    </tr>
	<tr>
    	<td colspan="3" style="text-align:left; height:26px;"><strong>Total:<?php echo round($totiva); ?></td>
    </tr>
 	<tr>
    	<td colspan="3" style="text-align:left; height:26px;">&nbsp;</td>
    </tr>
 	<tr>
    	<td colspan="3" style="text-align:center; height:26px;">*Gracias por su preferencia*</td>
    </tr>


</table>
</div>
</BODY>
</HTML>
<script type="text/javascript">
function redireccionarPagina() {
	window.location = "cabecera.php";
}
setTimeout("redireccionarPagina()", 800);
</script>
