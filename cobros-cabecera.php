<?php 
  session_start();
  include('_conexion.php');
  include('cabezote.php');
  include('menu.php');

  if (empty($_SESSION['login_user'])) {
    echo '<script>location.href="index.php";</script>';
  }
  
  if ($_GET['clie_id']) {
    $sqlcp="SELECT nombres, ruc, telefono, direccion, barrio, ubicacion FROM clientes WHERE idclie= ".$_GET['clie_id'];
    $datoscp = pg_query ($con, $sqlcp) or die ("Problemas en $-campos: 3 ".pg_last_error ());
    $dtcp=pg_fetch_array($datoscp);
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Proyectos - e | COBRANZAS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- JQuery UI -->
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <!-- Alertity -->
  <link rel="stylesheet" href="libs/js/alertify/themes/alertify.core.css" />
  <link rel="stylesheet" href="libs/js/alertify/themes/alertify.bootstrap.css" id="toggleCSS" />
  <script src="libs/js/alertify/lib/alertify.min.js"></script>
    <!-- DataTables -->
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
    <!-- AJAX -->
  <script type="text/javascript" src="libs/ajax.js"></script>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>COBRANZAS</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Caja: <?php echo $_SESSION['login_nrocaja'] ?></a></li>
              <li class="breadcrumb-item active">Usuario: <?php echo $_SESSION['login_user'] ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <?php if($_GET['ok']){ ?>
    <div class="row justify-content-md-center">
      <div class="col-8 my-2">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong> Recibo guardado correctamente! </strong>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
    </div>
    <?php } ?>
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-sm-8">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Cliente</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              
                <div class="card-body">
                  
                  <div class="form-group form-row">
                    <div class="col-md-8">
                      <label>Cliente</label>
                      <input id="txt_cliente" name="txt_cliente" type="text" class="form-control" placeholder="Ingresar Cliente...">
                    </div>  
                  </div>

                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" id="confirm">Confirmar Cobro</button>
                </div>
              
            </div>
            <!-- /.card -->

            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Facturas Pendientes</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              
                <div class="card-body">
                <table class="table table-bordered table-striped dt-responsive tablaListaVentas" width="100%">
                  <thead>
                  
                    <tr>
                      <th style="width:5px">Nro</th>                
                      <th>Fecha</th>                
                      <th>Monto</th>
                      <th>Saldo</th>
                      <th>Acciones</th>
                    </tr>

                  </thead>

                </table>
                </div>
              
            </div>
            <!-- /.card -->
            
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Facturas a cobrar</h3>

                <div class="card-tools" id="montoVisor">
                  <?php  include('cobros-total.php'); ?>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0 lista-facturas">
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
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
<!-- COBRAR -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">COBRAR</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>

      <div class="modal-body">
        <form name="form_cobros" id="form_cobros" method="post" action="guardar_cobros.php?opcion=3">
        <div class="row" id="montoc">
            <?php include('total.php'); ?>
        </div>
    
        <input id="txt_idclie" name="txt_idclie" type="hidden" />
      
    <div class="form-group">  
      
      <div class="form-row">
        <p style="font-size:18px; margin-top:30px;"><strong>Datos del Cliente:</strong></p>
        <div class="form-group col-md-10">
          <strong>Nombre:</strong>
          <input id="txt_nombre" name="txt_nombre" type="text" class="form-control" style="font-size:18px;" disable="disable"/>
        </div>
        <div class="form-group col-md-10">
          <strong>RUC:</strong>
          <input id="txt_ruc" name="txt_ruc" type="text" class=" form-control" style="font-size:18px;" disable="disable"/>
        </div>
      </div>

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
          <label for="inputPassword4">Deposito Bancario</label>
          <input type="number" class="form-control" name="tarjeta" id="tarjeta" value="0">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="inputEmail4">Retencion Nro</label>
          <input type="text" class="form-control" name="retencion_nro" id="retencion_nro" value="0">
        </div>
        <div class="form-group col-md-4">
          <label for="inputPassword4">Retencion Fecha</label>
          <input type="date" class="form-control" name="retencion_fecha" id="retencion_fecha" value="0">
        </div>
        <div class="form-group col-md-4">
          <label for="inputPassword4">Retencion Monto</label>
          <input type="number" class="form-control" name="retencion_monto" id="retencion_monto" value="0">
        </div>
      </div>
    
    </div> <!-- form group -->

    </div> <!-- modal body -->

     <!-- modal content -->

    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      <button onclick="validar()" id="enviar" type="button" class="btn btn-success">Guardar</button>
    </div>

    </form>
    
  </div>
  </div>
</div><!-- </ COBRAR -->

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      
    </div>
    <strong>Copyright &copy; 2021 <a href="#">Proyectos - e</a>.</strong> 
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->


<script type="text/javascript">   
    $(function(){
    //validacion de tipo de venta
      $("#txt_cliente").autocomplete({
        source: "buscar_clie.php",    
        minLength: 3,         
        select: registroSeleccionado, 
        focus: registroMarcado
      })

    });
    
    function registroSeleccionado(event, ui){
      let registro = ui.item.value;  
      let descrip = registro.descripcion;
      let porcion = descrip.split('|');
      let mostrar =  porcion[0]+' | '+porcion[1]+' | '+porcion[2];
      $("#txt_idclie").val(registro.id);
      $("#txt_cliente").val(mostrar);
      $("#txt_nombre").val(porcion[0]);
      $("#txt_ruc").val(porcion[1]);
      
      $('.tablaListaVentas').DataTable().destroy();
      $(".tablaListaVentas").DataTable({
        "ajax": {
                "type": "POST",
                "url": "cobros-datatable.php",
                "data": {
                    "idclie": registro.id
                        }
                },
        "deferRender": true,
        "retrieve": true,
        "processing": true,
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }

      } );
      $('.tablaListaVentas').DataTable().ajax.reload();
      event.preventDefault();
    }
    
    function registroMarcado(event, ui){
      let registro = ui.item.value; 
      let descrip = registro.descripcion;
      let porcion = descrip.split('|'); 
      $("#txt_cliente").val(porcion[0]);
      $("#txt_ruc").val(porcion[1]);
      event.preventDefault();
    }

  function agregar_factura(idventa, nro, total, saldo){
	$.ajax({
	  url: 'Controller/CobrosController.php?page=1',
	  type: 'post',
	  data: {'idventa':idventa, 'nro':nro, 'total':total, 'saldo':saldo},
	  dataType: 'json'
	}).done(function(data){
	  if(data.success==true){
		alertify.success(data.msj);
		$(".lista-facturas").load('cobros-detalle.php');
		$("#montoc").load('cobros-total.php');
		$("#montoVisor").load('cobros-total.php');
	  }else{
		alertify.error(data.msj);
	  }
	})
	}

  function eliminar_factura(id){
	$.ajax({
		  url: 'Controller/CobrosController.php?page=2',
		  type: 'post',
		  data: {'id':id},
		  dataType: 'json'
	}).done(function(data){
	  if(data.success==true){
		alertify.success(data.msj);
		$(".lista-facturas").load('cobros-detalle.php');
		$("#montoc").load('cobros-total.php');
		$("#montoVisor").load('cobros-total.php');
	  }else{
		alertify.error(data.msj);
	  }
	})
	}

  function actualizar_monto(id){
    let idcarro = $(`#editar_id${id}`).val();
		let idventa = $(`#editar_idventa${id}`).val();
		let nro = $(`#editar_nro${id}`).val();
		let total = $(`#editar_total${id}`).val();
		let saldo = parseInt($(`#editar_saldo${id}`).val());
		let pagar = parseInt($(`#editar_pagar${id}`).val());
console.log(`saldo: ${saldo} pagar: ${pagar}`)
    if(pagar > saldo){
      alert('El monto ingresado es mayor al saldo!');
    }else{
    
    $.ajax({
			url: 'Controller/CobrosController.php?page=3',
			type: 'post',
			data: {'idventa':idventa, 'nro':nro, 'total':total, 'saldo':saldo, 'id':idcarro, 'pagar':pagar},
			dataType: 'json'
		}).done(function(data){
			if(data.success==true){
				alertify.success(data.msj);
        $(".lista-facturas").load('cobros-detalle.php');
        $("#montoc").load('cobros-total.php');
        $("#montoVisor").load('cobros-total.php');
			}else{
				alertify.error(data.msj);
			}
		}) 
  }//validacion
  }

function sepmiles(x) { return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."); }

function enviar(){
  let vta = $("#txt_venta").val();
  let plazo = $("#txt_plazo").val();
  $("#tipovta").val(vta);
  $("#plazo").val(plazo);
  $("#formGuardar").submit()
}

function validar(){
  let sum = 0;
  let efec = parseInt($('#efectivo').val());
  let cheq = parseInt($('#cheque').val());
  let tarj = parseInt($('#tarjeta').val());
  let retencion = parseInt($('#retencion_monto').val());
  let saldos = parseInt($('#saldos').val());

  sum = efec + cheq + tarj + retencion;
  if (sum > parseInt(saldos)){
    alert('El monto ingresado es mayor a la suma de saldos!');
  }else{
    $('#form_cobros').submit();
  }
}
    
;
  </script>

</body>
</html>
