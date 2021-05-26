<?php 
	include('_conexion.php');
	
	$datos = pg_query ($con, "SELECT precio, precio2, precio3, precio4 FROM articulos WHERE idart='".$_GET['id']."'") 
		or die ("Problemas:".pg_last_error ());
	$dt=pg_fetch_array($datos);
?>

			<div style="width:400px; float:left; margin-right:20px; margin-bottom: 30px;">
        		<strong>Cantidad:</strong>
				<input id="editar_cantidad" name="editar_cantidad" type="text" class="col-md-2 form-control" style="font-size:18px;" />
			</div>

			<div style="width:400px; float:left; margin-right:20px; margin-bottom: 30px;">
				<div><strong>Precio:</strong>
					<select id="editar_precio" name="editar_precio" class="col-md-2 form-control">
					  		<option value="<?php echo $dt['precio']; ?>" selected>Precio 1 - <?php echo $dt['precio']; ?></option>
					  		<option value="<?php echo $dt['precio2']; ?>" selected>Precio 2 - <?php echo $dt['precio2']; ?></option>
					  		<option value="<?php echo $dt['precio3']; ?>" selected>Precio 3 - <?php echo $dt['precio3']; ?></option>
					  		<option value="<?php echo $dt['precio4']; ?>" selected>Precio 4 - <?php echo $dt['precio4']; ?></option>
					</select>
				  
				</div>
			</div>

			<div style="width:400px; float:left; margin-right:20px; margin-bottom: 30px;">
        		<strong>Descuento:</strong>
				<input id="editar_precio" placeholder="Descuento" type="text" class="col-md-2 form-control" value="0" style="font-size:18px;" />
			</div>