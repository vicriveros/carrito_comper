<?php 
include('_conexion.php');
@session_start();
?>
<table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Codigo</th>
                      <th>Descripci&oacute;n</th>
                      <th>Cant.</th>
                      <th>Precio</th>
                      <th>Total</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody >
                    <?php 
                    if(count($_SESSION['detalle'])>0){
                      foreach($_SESSION['detalle'] as $k => $detalle){ ?>
                      <tr>
                        <td><?php echo $detalle['codigo'];?></td>
                        <td><?php echo $detalle['producto'];?></td>
                        <td><?php echo $detalle['cantidad'];?></td>
                        <td><?php echo number_format($detalle['precio'], 0, ',', '.');?></td>
                        <td><?php echo number_format($detalle['total'], 0, ',', '.');?></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-warning edit-art" data-toggle="modal" data-target="#editarModal<?php echo $detalle['idart'];?>" id="<?php echo $detalle['idart'];?>">Editar</button>
                          <button type="button" class="btn btn-sm btn-danger eliminar-producto" id="<?php echo $detalle['id'];?>">Eliminar</button>
                        </td>
                      </tr>
                    <?php }
                    }else{?>
                    <tr><td colspan="7"> No hay productos agregados </td></tr>
                    <?php }?>
                  </tbody>
                </table>
	
<?php
if(count($_SESSION['detalle'])>0){ 
	foreach($_SESSION['detalle'] as $k => $detalle){ 
	$datos = pg_query ($con, "SELECT precio, precio2, precio3, precio4 FROM articulos WHERE idart='".$detalle['idart']."'") 
		or die ("Problemas:".pg_last_error ());
	$dt=pg_fetch_array($datos);
?>
<!-- EDITAR -->
<div class="modal fade" id="editarModal<?php echo $detalle['idart']?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
      	<h4 class="modal-title" id="myModalLabel">EDITAR</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>

      <div class="modal-body">
		<div class="form-row">
			<input type="hidden" id="editar_id<?php echo $detalle['idart']?>" value="<?php echo $detalle['id'];?>">
			<input type="hidden" id="editar_articulo<?php echo $detalle['idart']?>" value="<?php echo $detalle['idart'];?>">
			<input type="hidden" id="editar_producto<?php echo $detalle['idart']?>" value="<?php echo $detalle['producto'];?>">
			<input type="hidden" id="editar_codigo<?php echo $detalle['idart']?>" value="<?php echo $detalle['codigo'];?>">
			<div class="editarArt"> 
        <div class="form-group col-md-12">
          <strong>Cantidad:</strong>
          <input id="editar_cantidad<?php echo $detalle['idart']?>" name="editar_cantidad" type="text" class="col-md-10 form-control" style="font-size:18px;" value='<?php echo $detalle['cantidad'];?>'/>
        </div>

        <div class="form-group col-md-12">
          <div><strong>Precio:</strong>
            <select id="editar_precio<?php echo $detalle['idart']?>" name="editar_precio" class="col-md-10 form-control">
                  <option value="<?php echo $dt['precio']; ?>" selected>Precio 1 - <?php echo number_format($dt['precio'], 0, ',', '.'); ?></option>
                  <option value="<?php echo $dt['precio2']; ?>" >Precio 2 - <?php echo number_format($dt['precio2'], 0, ',', '.'); ?></option>
                  <option value="<?php echo $dt['precio3']; ?>" >Precio 3 - <?php echo number_format($dt['precio3'], 0, ',', '.'); ?></option>
                  <option value="<?php echo $dt['precio4']; ?>" >Precio 4 - <?php echo number_format($dt['precio4'], 0, ',', '.'); ?></option>
            </select>
            
          </div>
        </div>

        <div class="form-group col-md-12">
          <strong>Descuento:</strong>
          <input id="editar_descuento<?php echo $detalle['idart']?>" placeholder="Descuento" type="text" class="col-md-10 form-control" value="0" style="font-size:18px;" />
        </div>

			</div> <!-- edit art -->
		</div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" data-dismiss="modal" class="btn btn-success guardar-edicion" id="<?php echo $detalle['idart'];?>">Guardar</button>
      </div>
    </div>
  </div>
</div><!-- </ EDITAR -->
<?php }
}?>

<script type="text/javascript" src="libs/ajax.js"></script>
