<?php 
session_start();


$caja=1;
$deposito=1;
$vend=1;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Punto de Ventas</title>

    <!-- Bootstrap -->
    <link href="libs/css/bootstrap.css" rel="stylesheet">
    <script src="libs/js/jquery.js"></script>
    <script src="libs/js/jquery-1.8.3.min.js"></script>
    <script src="libs/js/bootstrap.min.js"></script>
   	
    <script type="text/javascript" src="libs/ajax.js"></script>
	
	 <!-- Alertity -->
    <link rel="stylesheet" href="libs/js/alertify/themes/alertify.core.css" />
	<link rel="stylesheet" href="libs/js/alertify/themes/alertify.bootstrap.css" id="toggleCSS" />
    <script src="libs/js/alertify/lib/alertify.min.js"></script>
    
    	 <!-- buscador ui -->
	<link rel="stylesheet" type="text/css" href="css/jquery.ui.css"/>

    	<!-- Add jQuery library -->
	<script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>
	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="js/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css?v=2.1.5" media="screen" />

  </head>

  <body>
 	<div class="container-">
 		
 		<div class="page-header">
			<h1>Cabecera
            <p style="width:250px; float:right; font-size:14px;"><strong>Caja: </strong> <?php echo $_SESSION['login_nrocaja'] ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Usuario: </strong><?php echo $_SESSION['login_user'] ?></p></h1>
            <div style="clear:both"></div>
		</div>

 		<div class="row">
 			<div class="col-md-4">	
				<div>Cliente: <input id="txt_cliente" name="txt_cliente" type="text" class="col-md-2 form-control" placeholder="Ingresar Cliente.." autocomplete="off" />
				</div>
			</div>

			<div class="col-md-2">
				<div>Tipo venta:
					<select id="txt_venta" name="txt_venta" class="col-md-2 form-control">
					  <option value="1" selected>Contado</option>
					  <option value="2">Credito</option>
					  
					</select>
				  
				</div>
			</div>

			<div class="col-md-2">
				<div>Plazo:
				  <input id="txt_plazo" name="txt_plazo" type="number" class="col-md-2 form-control" value="0" placeholder="Ingrese cantidad" autocomplete="off" />
				</div>
			</div>

			<div class="col-md-2">
				<div style="margin-top: 19px; float: right;">
				<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" id="confirm"> Procesar</button>
				</div>
			</div>
		</div>
		<br>
 	</div>

<!-- Detalle -->

<div class="container-">
	<div class="page-header">
			<h1>Detalle de Ventas </h1>
           
            <div style="clear:both"></div>
		</div>

 		<div class="row">
			<div class="col-md-2">
				<!--id del articulo--> <input id="txt_idart" name="txt_idart" type="hidden" class="col-md-2 form-control"  />
                <div>Cantidad:
				  <input id="txt_cantidad" name="txt_cantidad" type="number" class="col-md-2 form-control" value="1" placeholder="Ingrese cantidad" autocomplete="off" />
				</div>
			</div>

			<div class="col-md-4">	
				<div>Producto: <input id="txt_producto" name="txt_producto" type="text" class="col-md-2 form-control" placeholder="Ingresar Producto.." autocomplete="off" />
				</div>
			</div>
			<div class="col-md-2">
				<div style="margin-top: 19px;">
				<button type="button" class="btn btn-success btn-agregar-producto btn-lg">Agregar</button>
				</div>
			</div>
			
			<div class="col-md-4">
				<div id="montoVisor">
		           	<?php  include('total.php'); ?>
				</div>
			</div>
		</div>
		
		<br>
		<div class="panel panel-info">
			 <div class="panel-heading">
		        <h3 class="panel-title">Productos</h3>
		      </div>
			<div class="panel-body detalle-producto">
				<?php if(count($_SESSION['detalle'])>0){?>
					<table class="table">
					    <thead>
					        <tr>
					            <th>ID</th>
                                <th>Codigo</th>
                                <th>Descripci&oacute;n</th>
					            <th>Cantidad</th>
					            <th>Precio</th>
					            <th>Total</th>
					        </tr>
					    </thead>
					    <tbody>
					    	<?php 
					    	foreach($_SESSION['detalle'] as $k => $detalle){ 
					    	?>
					        <tr>
					        	<td><?php echo $detalle['idart'];?></td>
                                <td><?php echo $detalle['codigo'];?></td>
                                <td><?php echo $detalle['producto'];?></td>
					            <td><?php echo $detalle['cantidad'];?></td>
					            <td><?php echo $detalle['precio'];?></td>
					            <td><?php echo $detalle['total'];?></td>
					            <td><button type="button" class="btn btn-sm btn-warning edit-art" data-toggle="modal" data-target="#editarModal<?php echo $detalle['idart'];?>" id="<?php echo $detalle['idart'];?>">Editar</button>
					            <button type="button" class="btn btn-sm btn-danger eliminar-producto" id="<?php echo $detalle['id'];?>">Eliminar</button></td>
					        </tr>
					        <?php }?>
					    </tbody>
					</table>
				<?php }else{?>
				<div class="panel-body"> No hay productos agregados</div>
				<?php }?>
			</div>
		</div>
 	</div>
    
	<script type="text/javascript" src="lib/jquery.1.7.1.js"></script>
	<script type="text/javascript" src="lib/jquery.ui.1.8.16.js"></script>
    
         
  
<!-- COBRAR -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">COBRAR</h4>
      </div>

      <div class="modal-body">
      	<div id="montoc">
           	<?php 
			include('total.php');
	    	?>
		</div>
            <form id="form1" method="post" action="confirmar.php">
            
			<input id="confir" name="confir" type="hidden" value="1" />

			<input id="txt_caja" name="txt_caja" type="hidden" value="<?php echo $_SESSION['login_caja']; ?>" />
			<input id="txt_deposito" name="txt_deposito" type="hidden" value="1" />
			<input id="txt_idclie" name="txt_idclie" type="hidden"  />
			<input id="tipovta" name="tipovta" type="hidden"  />
			<input id="plazo" name="plazo" type="hidden"  />
			
		
		<div class="row">
			<div class="form-row">
			  <div class="form-group col-md-4">
			      <label for="inputEmail4">Efectivo</label>
			      <input type="number" class="form-control" name="efectivo" id="efectivo" value="0">
			    </div>
			    <div class="form-group col-md-4">
			      <label for="inputPassword4">Cheque</label>
			      <input type="number" class="form-control" name="cheque" id="cheque" value="0">
			    </div>
			    <div class="form-group col-md-4">
			      <label for="inputPassword4">Tarjeta</label>
			      <input type="number" class="form-control" name="tarjeta" id="tarjeta" value="0">
			    </div>
			</div>
			<div class="form-row">
			  <div class="form-group col-md-4">
			      <label for="inputEmail4">Cheque Ad</label>
			      <input type="number" class="form-control" name="chequead" id="chequead"  value="0">
			    </div>
			    <div class="form-group col-md-4">
			      <label for="inputPassword4">Giros Tigo</label>
			      <input type="number" class="form-control" name="giros" id="giros" value="0">
			    </div>
			    <div class="form-group col-md-4">
			      <label for="inputPassword4">Deposito Bancario</label>
			      <input type="number" class="form-control" name="depositoban" id="depositoban" value="0">
			    </div>
			</div>

		<div class="col-md-4">

				<p style="font-size:18px; margin-top:30px;"><strong>Datos del Cliente:</strong></p>
			<div style="width:400px; float:left; margin-right:20px;">
        		<strong>Nombre:</strong>
				<input id="txt_nombre" name="txt_nombre" type="text" class="col-md-2 form-control" style="font-size:18px;" disable="disable"/>
			</div>

			<div style="width:200px; float:left; margin-right:20px;">
        		<strong>RUC:</strong>
				<input id="txt_ruc" name="txt_ruc" type="text" class="col-md-2 form-control" style="font-size:18px;" disable="disable"/>
			</div>

		</div>

		</div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button onclick="javascript:enviar()" type="button" class="btn btn-success">Guardar</button>
      </form></div>
    </div>
  </div>
</div><!-- </ COBRAR -->


	
<script type="text/javascript">
 $("#txt_producto").keydown(function(tecla){
	if (tecla.keyCode == 13) {
		$(".btn-agregar-producto").click(); 
    }
});
	$(function() 
    {
      $("#txt_producto").autocomplete({
        source: "buscar_art.php", 
        minLength: 3,     
        select: Seleccionado, 
        focus: Marcado
      }).focus();

      $("#txt_cliente").autocomplete({
        source: "buscar_clie.php",    
        minLength: 3,         
        select: registroSeleccionado, 
        focus: registroMarcado
      })

    });
    
    function registroSeleccionado(event, ui)
    {
      let registro = ui.item.value;  
      let descrip = registro.descripcion;
      let porcion = descrip.split('|'); 
      $("#txt_idclie").val(registro.id);
      $("#txt_cliente").val(porcion[0]);
      $("#txt_nombre").val(porcion[0]);
      $("#txt_ruc").val(porcion[1]);
      event.preventDefault();
    }
    
    function registroMarcado(event, ui)
    {
      let registro = ui.item.value; 
      let descrip = registro.descripcion;
      let porcion = descrip.split('|'); 
      $("#txt_cliente").val(porcion[0]);
      $("#txt_ruc").val(porcion[1]);
      event.preventDefault();
    }
    
    function Seleccionado(event, ui)
    {
      let registro = ui.item.value;
      let descrip = registro.descripcion;
      let porcion = descrip.split('|');
      $("#txt_idart").val(registro.id);
      $("#txt_producto").val(porcion[0]);
      event.preventDefault();
    }
    
    function Marcado(event, ui)
    {
      let registro = ui.item.value; 
      let descrip = registro.descripcion;
      let porcion = descrip.split('|');
      $("#txt_producto").val(porcion[0]);
      $("#txt_precio").val(porcion[1].slice(0, -3));
      event.preventDefault();
    }

    function sepmiles(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function vuelto()
    { 
      let tot = $("#txt_tot").val();
      let ingresa = $("#txt_ingresa").val();
      let vuelto=sepmiles(ingresa-tot);
      $("#txt_vuelto").val(vuelto);
    }	

    function enviar(){
		let vta = $("#txt_venta").val();
		let plazo = $("#txt_plazo").val();
		$("#tipovta").val(vta);
		$("#plazo").val(plazo);
		$("#form1").submit()
	}	
		
	</script>



  </body>
</html>
