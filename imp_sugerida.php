<?php  //Configuracion de la conexion a base de datos
@session_start();
include('_conexion.php'); 

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
		<td colspan="4" width="176" style="text-align:center; font-size:22px; font-family:Arial;"><strong>COMPER</strong></td>
    </tr>
	<tr>
    	<td colspan="4" style="font-size:9px; text-align:center;"> <strong>Compra Sugerida </strong></td>
    </tr>
	
	<tr>
    	<th width="38" style="font-size:12px";>Cant.</th>
    	<th width="176" style="font-size:12px">Articulo</th>
    	<th width="176" style="font-size:12px">Precio</th>
    	<th width="176" style="font-size:12px">Total</th>
    </tr>
	<?php 
	$tot=0;
	foreach($_SESSION['detalle'] as $k => $detalle){
        $tot1=$detalle['cantidad']*$detalle['precio'];

	$tot=$tot+$tot1;
	?>
	<tr>
    	<td width="38" style="font-size:11px"><?php echo number_format($detalle['cantidad'], 0, ',', '.'); ?></td>
    	<td colspan="3" style="font-size:11px" width="400"><?php echo $detalle['producto']; ?></td>
	</tr>
	<tr>
		<td width="38" style="font-size:11px"></td>
		<td width="38" style="font-size:11px"></td>
    	<td width="38" style="font-size:11px"><?php echo number_format($detalle['precio'], 0, ',', '.'); ?></td>
    	<td width="38" style="font-size:11px"><?php echo number_format($tot1, 0, ',', '.'); ?></td>
    </tr>
    
 <?php 
 }
	
 ?> 
	<tr>
    	<td colspan="4" width="176" style="text-align:left; font-size:14px; font-family:Arial;"><strong>Total:</strong> <?php echo  number_format($tot, 0, ',', '.') ?></td>
    </tr>

 	<tr>
    	<td colspan="4" style="text-align:center; height:26px;">*Gracias por su preferencia*</td>
    </tr>

</table>
</div>

</BODY>
</HTML>
<script type="text/javascript">
function redireccionarPagina() {
	window.location = "cabecera.php";
}
//setTimeout("redireccionarPagina()", 800);
</script>