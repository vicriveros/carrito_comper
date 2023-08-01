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
		$json['msj'] = 'Producto Agregado';
		$json['success'] = true;
	
		if ($_POST['producto']!='' && $_POST['cantidad'] > 0) {
			/** Validacion de Articulos */
			$match=false;
			foreach($_SESSION['detalle'] as $k => $detalle){
				if($detalle["idart"] == $_POST['idart']){ $match=true; }
			}
			if ($match == true) {
				$json['msj'] = 'El articulo ya fue cargado';
				$json['success'] = false;
				echo json_encode($json);
			}else{
			/** Validacion de Articulos */

			$datos = pg_query ($con, "SELECT codfab, precio2 FROM articulos WHERE idart='".$_POST['idart']."'") or die ("Problemas en $-campos:".pg_last_error ());
				$dt=pg_fetch_array($datos);
				$precio= $dt["precio2"];
				$codigo = $dt["codfab"];
						
			$stock=pg_query ($con, "SELECT cant, idart FROM detstock WHERE idart=".$_POST['idart']." and iddeposito=".$_SESSION['login_deposito']) or die ("Problemas en $-campos:".pg_last_error ());
				$result=pg_fetch_array($stock);		
				$cntStock=$result["cant"];
				$cantidad = $_POST['cantidad'];

				/*stock COMBOS*/
					$stockComboValidation = true;
					$sqlSubArt="SELECT idsubart, cant FROM subarticulos WHERE idart=".$_POST["idart"];
					$subArt = pg_query ($con, $sqlSubArt) or die ("Problemas en $-campos sqlSubArt:".pg_last_error ());
					$cantRows=pg_num_rows($subArt);
					if($cantRows > 0){
						while ($sa=pg_fetch_array($subArt)) {
							$sqlStock="SELECT cant FROM detstock WHERE idart=".$sa["idsubart"]." and iddeposito=".$_SESSION['login_deposito'];
							$qStock = pg_query ($con, $sqlStock) or die ("Problemas en $-campos cant stk sub art:".pg_last_error ());
							$stk=pg_fetch_array($qStock);
							if($stk["cant"] <= 0){
								$stockComboValidation = false;
							}
						}
					}
	
			if($stockComboValidation == true){/*stock COMBOS*/
					
			if($cantidad<=$cntStock){
			
				try {
						
						$producto = $_POST['producto'];
						$idart = $_POST['idart'];
						$total=$cantidad*$precio;
						
						if(count($_SESSION['detalle'])>0){
							$ultimo = end($_SESSION['detalle']);
							$count = $ultimo['id']+1;
						}else{
							$count = count($_SESSION['detalle'])+1;
						}
						$_SESSION['detalle'][$count] = array('id'=>$count, 'producto'=>$producto, 'cantidad'=>$cantidad, 'codigo'=>$codigo, 'idart'=>$idart, 'precio'=>$precio, 'total'=>$total);

						$json['success'] = true;

						echo json_encode($json);

				}catch (PDOException $e) {
					$json['msj'] = $e->getMessage();
					$json['success'] = false;
					echo json_encode($json);
				}
			}else{

				$json['msj'] = 'La cantidad cargada supera el stock disponible';
				$json['success'] = false;
				echo json_encode($json);

			}
			}else{ /*stock COMBOS*/
				$json['msj'] = 'Los articulos componentes del combo no tienen stock disponible';
				$json['success'] = false;
				echo json_encode($json);
			}
		}/** Validacion de Articulos */
		}else{
				if ($_POST['codigo']!='' && $_POST['cantidad'] > 0) {
					$datos = pg_query ($con, "SELECT nombres, idart, codfab, precio FROM articulos WHERE codfab='".$_POST['codigo']."'") or die ("Problemas en $-campos:".pg_last_error ());
					
					$row=pg_num_rows($datos);
					if ($row>0){
						while($dt=pg_fetch_array($datos)){
							$producto = $dt["nombres"];
							$idart =  $dt["idart"];
							$precio= $dt["precio"];
						}
				try{
					$cantidad = $_POST['cantidad'];
					$codigo = $_POST['codigo'];
					$total=$precio*$cantidad;
					

					if(count($_SESSION['detalle'])>0){
						$ultimo = end($_SESSION['detalle']);
						$count = $ultimo['id']+1;
					}else{
						$count = count($_SESSION['detalle'])+1;
					}
					$_SESSION['detalle'][$count] = array('id'=>$count, 'producto'=>$producto, 'cantidad'=>$cantidad, 'codigo'=>$codigo, 'idart'=>$idart, 'precio'=>$precio, 'total'=>$total);
	
					$json['success'] = true;
	
					echo json_encode($json);
		
				   }catch (PDOException $e) {
					$json['msj'] = $e->getMessage();
					$json['success'] = false;
					echo json_encode($json);
					}
		
					}else{
						$json['msj'] = '¡Error! No se encuentra el Codigo de Barras.';
						$json['success'] = false;
						echo json_encode($json);					
					}
				}else{
					$json['msj'] = 'Ingrese un producto y/o ingrese cantidad';
					$json['success'] = false;
					echo json_encode($json);
				}
		}
		break;

	case 2:
		$json = array();
		$json['msj'] = 'Producto Eliminado';
		$json['success'] = true;
	
		if (isset($_POST['id'])) {
			try {
				unset($_SESSION['detalle'][$_POST['id']]);
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
		$json['msj'] = 'Producto Editado';
		$json['success'] = true;
	
		$stock=pg_query ($con, "SELECT cant, idart FROM detstock WHERE idart=".$_POST['idart']." and iddeposito=".$_SESSION['login_deposito']) or die ("Problemas en $-campos:".pg_last_error ());
		$result=pg_fetch_array($stock);		
		$cntStock=$result["cant"];

		$cantidad = $_POST['cantidad'];

		if($cantidad<=$cntStock){

			try{

					// $cantidad = $_POST['cantidad'];
					$codigo = $_POST['codigo'];
					$producto = $_POST['producto'];
					$idart = $_POST['idart'];
					$precio = $_POST['precio'] - $_POST['descuento'];
					$total = $precio * $cantidad;

					if(count($_SESSION['detalle'])>0){
						$ultimo = end($_SESSION['detalle']);
						$count = $ultimo['id']+1;
					}else{
						$count = count($_SESSION['detalle'])+1;
					}
					$_SESSION['detalle'][$count] = array('id'=>$count, 'producto'=>$producto, 'cantidad'=>$cantidad, 'codigo'=>$codigo, 'idart'=>$idart, 'precio'=>$precio, 'total'=>$total);

					unset($_SESSION['detalle'][$_POST['id']]);
	
					$json['success'] = true;
	
					echo json_encode($json);
		
				   }catch (PDOException $e) {
					$json['msj'] = $e->getMessage();
					$json['success'] = false;
					echo json_encode($json);
					}

		}else{

			$json['msj'] = 'La cantidad cargada supera el stock disponible';
			$json['success'] = false;
			echo json_encode($json);

		}
		break;


}
?>