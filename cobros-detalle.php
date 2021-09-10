<?php 
include('_conexion.php');
@session_start();
?>
<table class="table table-hover text-nowrap">
  <thead>
    <tr>
    <th style="width:5px">Nro</th>                           
    <th>Monto</th>
    <th>Saldo</th>
    <th>Pagar</th>
    <th>Acciones</th>
  </tr>
  </thead>
  <tbody >
    <?php 
        if(count($_SESSION['detcobros'])>0){
          foreach($_SESSION['detcobros'] as $k => $detalle){ ?>
          <tr>
            <td><?php echo $detalle['nro'];?></td>
            <td><?php echo number_format($detalle['total'], 0, ',', '.');?></td>
            <td><?php echo number_format($detalle['saldo'], 0, ',', '.');?></td>
            <td><?php echo number_format($detalle['pagar'], 0, ',', '.');?></td>
            <td>
              <button type="button" class="btn btn-sm btn-warning edit-factura" data-toggle="modal" data-target="#editarModal<?php echo $detalle['idventa'];?>" id="<?php echo $detalle['idventa'];?>">Editar</button>
              <button onclick="eliminar_factura(<?php echo $detalle['id'];?>)" type="button" class="btn btn-sm btn-danger eliminar-factura">Eliminar</button>
            </td>
          </tr>
        <?php }
        }else{?>
        <tr><td colspan="5"> No hay facturas agregadas </td></tr>
    <?php }?>
  </tbody>
</table>
	
<?php
  if(count($_SESSION['detcobros'])>0){
    foreach($_SESSION['detcobros'] as $k => $detalle){ 
    
?>
<!-- EDITAR -->
<div class="modal fade" id="editarModal<?php echo $detalle['idventa']?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
      	<h4 class="modal-title" id="myModalLabel">EDITAR</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>

      <div class="modal-body">
		<div class="form-row">
			<input type="hidden" id="editar_id<?php echo $detalle['idventa']?>" value="<?php echo $detalle['id'];?>">
			<input type="hidden" id="editar_idventa<?php echo $detalle['idventa']?>" value="<?php echo $detalle['idventa'];?>">
			<input type="hidden" id="editar_nro<?php echo $detalle['idventa']?>" value="<?php echo $detalle['nro'];?>">
			<input type="hidden" id="editar_total<?php echo $detalle['idventa']?>" value="<?php echo $detalle['total'];?>">
      <input type="hidden" id="editar_saldo<?php echo $detalle['idventa']?>" value="<?php echo $detalle['saldo'];?>">
			<div class="editarArt"> 
        <div class="form-group col-md-12">
          <strong>Pagar:</strong>
          <input id="editar_pagar<?php echo $detalle['idventa']?>" name="editar_pagar" type="text" class="col-md-10 form-control" style="font-size:18px;" value='<?php echo $detalle['pagar'];?>'/>
        </div>

			</div> <!-- edit art -->
		</div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button onclick="actualizar_monto(<?php echo $detalle['idventa'];?>)" type="button" data-dismiss="modal" class="btn btn-success" >Guardar</button>
      </div>
    </div>
  </div>
</div><!-- </ EDITAR -->
<?php }
}?>

<script type="text/javascript" src="libs/ajax.js"></script>