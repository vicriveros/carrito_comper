<?php include('_conexion.php');  

if ($_GET["term"]){

$criterio = strtoupper($_GET["term"]);
$sql="SELECT nombres, idclie, ruc, barrio FROM clientes WHERE nombres LIKE '%".$criterio."%' or barrio LIKE '%".$criterio."%'";
$datos = pg_query ($con, $sql) or die ("Problemas en $-campos:".pg_last_error ());

$contador = 0;
$resul='[';
while($dt=pg_fetch_array($datos)){
	if ($contador > 0) {$resul.= ", ";}
	$des=$dt['nombres'].'|'.$dt['ruc'];
	$resul.='{ "label" : "'.$dt['nombres'].' | '.$dt['barrio'].'", "value" : { "id" : '.$dt['idclie'].', "descripcion" : "'.$des.'" } }';
	
	$contador++;
	
	}
	
	echo $resul.']';
}
?>


