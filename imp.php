<?php  //Configuracion de la conexion a base de datos
@session_start();
include('_conexion.php'); 


	$sqlcab="SELECT clie_id, total_venta, fac_fecha, hora, id_caja, tipo_ventas, idventa, total_iva, total_iva5 FROM cab_ventas WHERE fac_nro=".$_GET["fac"]." and id_caja=".$_SESSION['login_caja'];
	$cab = pg_query ($con, $sqlcab) or die ("Problemas en $-campos cabecera:".pg_last_error ());
	$cb=pg_fetch_array($cab);

	$cf=strlen($_GET["fac"]);
	$fal=7-$cf;
	$nroini='';
	for ($i = 1; $i <= $fal; $i++) {
    	$nroini.='0';
	}

	$sql2="SELECT nro FROM cajas WHERE id_caja=".$cb['id_caja'];
	$cons2=pg_query($con, $sql2)or die ("Problemas en consulta ".pg_last_error ());
	$nca=pg_fetch_array($cons2);

	$sqlclie="SELECT clie_nombre, clie_ruc FROM clientes WHERE clie_id=". $cb['clie_id'];
	$clie = pg_query ($con, $sqlclie) or die ("Problemas en $-campos clie:".pg_last_error ());
	$cl=pg_fetch_array($clie);

?>
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
<SCRIPT language="javascript">
function imprimir()
{ if ((navigator.appName == "Netscape")) { window.print() ;
}
else
{ var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
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
    	<td colspan="3" style="text-align:center;">Timbrado:11376188 - VTO:31/12/2016</td>
    </tr>
    <tr>
    	<td colspan="3" style="text-align:center;">Telefono:021 207 167</td>
    </tr>
    <tr>
    	<td colspan="3" style="text-align:center;">Fecha y Hora de Emision: <?php echo $cb['fac_fecha'].' '.$cb['hora'] ?></td>
    </tr>
    <tr>
    	<td colspan="3" style="text-align:center;">Factura <?php if ($cb['tipo_ventas'] == 1) { echo "Contado";}else{ echo "Credito";} ?>
            
          N°:</br> 001-<?php echo $nca[0] ?>-<?php echo $nroini.$_GET["fac"] ?></td>
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
	$sqldet="SELECT art_id, cantidad, punitario FROM det_ventas WHERE fac_nro=".$_GET['fac']." and idventa=".$cb['idventa'];
	$det = pg_query ($con, $sqldet) or die ("Problemas en $-campos detalle1:".pg_last_error ());
	
	while($dt=pg_fetch_array($det)){
	
	$sqlart="SELECT art_nombre FROM articulos WHERE art_id=". $dt['art_id'];
	$arti = pg_query ($con, $sqlart) or die ("Problemas en $-campos detalle art:".pg_last_error ());
	$at=pg_fetch_array($arti);
	$art=$at['art_nombre'];

	$tot1=$dt['cantidad']*$dt['punitario'];
	$tot=$tot+$tot1;
?>
	<tr>
    	<td width="38"><?php echo $dt['cantidad']; ?></td>
    	<td width="176"><?php echo $art; ?></td>
    	<td width="38"><?php echo number_format($dt['punitario'], 0, ',', '.'); ?></td>
    	<td width="38"><?php echo number_format($tot1, 0, ',', '.'); ?></td>
    </tr>
    
 <?php 
 }
$totiva=$cb['total_iva']+$cb['total_iva5'];
 ?> 
	<tr>
    	<td colspan="3" width="176" style="text-align:left; font-size:22px; font-family:Arial;"><strong>Total:</strong> <?php echo  number_format($cb['total_venta'], 0, ',', '.') ?></td>
    </tr>

 	<tr>
    	<td colspan="3" style="text-align:left; height:26px;">&nbsp;</td>
    </tr>
	<tr>
    	<th colspan="3" style="text-align:left; height:26px;"><strong>-- Datos del Cliente--</th>
    </tr>
	<tr>
    	<td colspan="3" style="text-align:left; height:26px;">Razon Social: <?php echo $cl['clie_nombre'] ?></td>
    </tr>
	<tr>
    	<td colspan="3" style="text-align:left; height:26px;">RUC/CI: <?php echo $cl['clie_ruc'] ?></td>
    </tr>
  
	<tr>
    	<td colspan="3" style="text-align:left; height:26px;"><strong>-- Liquidacion de IVA --</td>
    </tr>
	<tr>
    	<td colspan="3" style="text-align:left; height:26px;">Exenta: 0</td>
    </tr>
	<tr>
    	<td colspan="3" style="text-align:left; height:26px;">10%:<?php echo round($cb['total_iva']); ?></td>
    </tr>
	<tr>
    	<td colspan="3" style="text-align:left; height:26px;">5%:<?php echo round($cb['total_iva5']); ?></td>
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
 	<tr>
    	<td colspan="3" style="text-align:center; height:26px;">Juan 3:16</td>
    </tr>

</table>
</div>
</BODY>
</HTML>
<script type="text/javascript">
function redireccionarPagina() {
	window.location = "carrito.php";
}
setTimeout("redireccionarPagina()", 800);
</script>
