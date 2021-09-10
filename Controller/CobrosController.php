<?php
session_start(); 
if(isset($_GET["page"])){
	$page=$_GET["page"];
}else{
	$page=0;
}

include('../_conexion.php');

switch($page){

	case 1:
		$json = array();
		$json['msj'] = 'Factura Agregada';
		$json['success'] = true;
					
			try {
				if(count($_SESSION['detcobros'])>0){
					$ultimo = end($_SESSION['detcobros']);
					$count = $ultimo['id']+1;
				}else{
					$count = count($_SESSION['detcobros'])+1;
				}
				foreach($_SESSION['detcobros'] as $k => $detalle){ 
					if($_POST['idventa'] == $detalle['idventa']){$sw=1;}else{$sw=0;}
				}
				if($sw == 0){
					$_SESSION['detcobros'][$count] = array('id'=>$count, 'idventa'=>$_POST['idventa'], 'nro'=>$_POST['nro'], 'total'=>$_POST['total'], 'saldo'=>$_POST['saldo'], 'pagar'=>$_POST['saldo']);
				}
				
				$json['success'] = true;

				echo json_encode($json);
	
			}catch (PDOException $e) {
				$json['msj'] = $e->getMessage();
				$json['success'] = false;
				echo json_encode($json);
			}
		
		break;

	case 2:
		$json = array();
		$json['msj'] = 'Factura Eliminada';
		$json['success'] = true;
	
		if (isset($_POST['id'])) {
			try {
				unset($_SESSION['detcobros'][$_POST['id']]);
				$json['success'] = true;
	
				echo json_encode($json);
	
			} catch (PDOException $e) {
				$json['msj'] = $e->getMessage();
				$json['success'] = false;
				echo json_encode($json);
			}
		}
		break;

	case 3:
		$json = array();
		$json['msj'] = 'Factura Editada';
		$json['success'] = true;
	
		try{

			if(count($_SESSION['detcobros'])>0){
				$ultimo = end($_SESSION['detcobros']);
				$count = $ultimo['id']+1;
			}else{
				$count = count($_SESSION['detcobros'])+1;
			}
			$_SESSION['detcobros'][$count] = array('id'=>$count, 'idventa'=>$_POST['idventa'], 'nro'=>$_POST['nro'], 'total'=>$_POST['total'], 'saldo'=>$_POST['saldo'], 'pagar'=>$_POST['pagar']);

			unset($_SESSION['detcobros'][$_POST['id']]);
	
			$json['success'] = true;
	
			echo json_encode($json);
		
		}catch (PDOException $e) {
			$json['msj'] = $e->getMessage();
			$json['success'] = false;
			echo json_encode($json);
		}
		break;

}
?>