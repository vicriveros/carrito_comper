<?php include('_conexion.php');  

if ($_GET["term"]){

$criterio = strtoupper($_GET["term"]);
$sql="SELECT nombres, idart, precio, codfab FROM articulos WHERE nombres LIKE '%".$criterio."%' OR codfab LIKE '%".$criterio."%'"; 
$datos = pg_query ($con, $sql) or die ("Problemas en $-campos:".pg_last_error ());

$contador = 0;
$resul='[';
while($dt=pg_fetch_array($datos)){
	if ($contador > 0) {$resul.= ", ";}
	$des=$dt['nombres'].'|'.$dt['precio'].'|'.$dt['codfab'];
	
	$resul.='{ "label" : "'.$dt['nombres'].'", "value" : { "id" : '.$dt['idart'].', "descripcion" : "'.$des.'" } }';
	
	$contador++;
	
	}
	
	echo $resul.']';
}
?>


