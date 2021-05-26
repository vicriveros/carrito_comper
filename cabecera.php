<?php 
  session_start();
  $caja=1;
  $deposito=1;
  $vend=1;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Proyectos - e | Punto de Ventas</title>
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
            <h1>Punto de Ventas</h1>
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
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Datos</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              
                <div class="card-body">
                  <div class="form-group">
                    <label>Cliente</label>
                    <input id="txt_cliente" name="txt_cliente" type="text" class="form-control" placeholder="Ingresar Cliente...">
                  </div>
                  <div class="form-group">
                    <label>Tipo Venta</label>
                    <select id="txt_venta" name="txt_venta" class="form-control">
                      <option value="1" selected>Contado</option>
                      <option value="2">Credito</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Plazo</label>
                    <input id="txt_plazo" name="txt_plazo" type="number" class="form-control" value="0" placeholder="Ingrese cantidad">
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" id="confirm">Confirmar Venta</button>
                </div>
              
            </div>
            <!-- /.card -->

            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Articulos</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              
                <div class="card-body">
                  <div class="form-group">
                    <!--id del articulo--> <input id="txt_idart" name="txt_idart" type="hidden" class="col-md-2 form-control"  />
                    <label>Cantidad</label>
                    <input id="txt_cantidad" name="txt_cantidad" type="number" class="form-control" value="1" placeholder="Ingrese cantidad">
                  </div>
                  
                  <div class="form-group">
                    <label>Producto</label>
                    <input id="txt_producto" name="txt_producto" type="text" class="form-control" placeholder="Ingresar Producto">
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="button" class="btn btn-success btn-agregar-producto">Agregar al Carrito</button>
                </div>
              
            </div>
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Detalle de Ventas</h3>

                <div class="card-tools" id="montoVisor">
                  <?php  include('total.php'); ?>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0 detalle-producto">
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
        <div class="row" id="montoc">
            <?php 
      include('total.php');
        ?>
    </div>
            <form id="formGuardar" method="post" action="confirmar.php">
            
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
      <div class="form-group col-md-4">
            <strong>Nombre:</strong>
        <input id="txt_nombre" name="txt_nombre" type="text" class="form-control" style="font-size:18px;" disable="disable"/>
      </div>

      <div class="form-group col-md-4">
            <strong>RUC:</strong>
        <input id="txt_ruc" name="txt_ruc" type="text" class=" form-control" style="font-size:18px;" disable="disable"/>
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
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      
    </div>
    <strong>Copyright &copy; 2020 <a href="#">Proyectos - e</a>.</strong> 
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AJAX -->
  <script type="text/javascript" src="libs/ajax.js"></script>
<!-- buscador ui -->
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- Alertity -->
    <link rel="stylesheet" href="libs/js/alertify/themes/alertify.core.css" />
  <link rel="stylesheet" href="libs/js/alertify/themes/alertify.bootstrap.css" id="toggleCSS" />
    <script src="libs/js/alertify/lib/alertify.min.js"></script>

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
    $("#formGuardar").submit()
  } 
    
  </script>

</body>
</html>
