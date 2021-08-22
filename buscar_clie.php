<?php include('_conexion.php');  

if ($_GET["term"]){

$criterio = strtoupper($_GET["term"]);
$sql="SELECT nombres, idclie, ruc, barrio, direccion, telefono, ubicacion FROM clientes WHERE nombres LIKE '%".$criterio."%' or barrio LIKE '%".$criterio."%' or ruc LIKE '%".$criterio."%'";
$datos = pg_query ($con, $sql) or die ("Problemas en $-campos:".pg_last_error ());

$contador = 0;
$resul='[';
while($dt=pg_fetch_array($datos)){
	if ($contador > 0) {$resul.= ", ";}
	$des=trim($dt['nombres']).'|'.trim($dt['barrio']).'|'.trim($dt['ruc']).'|'.trim($dt['direccion']).'|'.trim($dt['telefono']).'|'.trim($dt['ubicacion']);
	$resul.='{ "label" : "'.trim($dt['nombres']).' | '.trim($dt['barrio']).'  | '.trim($dt['ruc']).'", "value" : { "id" : '.$dt['idclie'].', "descripcion" : "'.$des.'" } }';
	
	$contador++;
	
	}
	
	echo $resul.']';
}
?>


