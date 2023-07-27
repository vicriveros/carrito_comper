<?php 
session_start();
  include('_conexion.php');
  include('cabezote.php');
  include('menu.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Proyectos - e | Punto de Cobros</title>
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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-">
            <h1>Cobro de Facturas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="cabecera.php">Home</a></li>
              <li class="breadcrumb-item active">Cobro de Facturas</li>
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
    <!-- Default box -->
      <div class="card">  
        <div class="card-header">
          <h3 class="card-title">Listado</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
          <form method="get" action="">
          <div class="form-group form-row">            
            <div class="col-md-8">
              <label>Cliente</label>
              <input id="txt_cliente" name="txt_cliente" type="text" class="form-control" placeholder="Ingresar Cliente...">
              <input id="txt_idclie" name="txt_idclie" type="hidden"  />
            </div>  

            <div class="col-md-4 text-center mt-1">
              <button type="submit" class="btn btn-warning" > Buscar </button>
            </div>
            
          </div>
          </form>

          <h5><?php echo $_GET['txt_cliente']; ?></h5>
          <h5>Facturas a cobrar:<?php foreach ($_SESSION['lista_facturas'] as $v) {
              $part = explode(",", $v);
             echo $part[0].', '; 
             } ?>
          </h5>
          <button type="button" class="btn btn-info mb-2" data-toggle="modal" data-target="#myModalCobro"> Cobrar </button>
          
          <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
            <thead>
            
              <tr>
                <th style="width:5px">Nro</th>                
                <th>Fecha</th>                
                <th>Monto</th>
                <th>Saldo</th>
                <th>Acciones</th>
              </tr>

            </thead>

            <tbody>
            <?php 
            if($_GET['txt_idclie']){
                // var_dump($_SESSION['login_vendedor']);
              $sql="SELECT a.idventa, a.nro, a.falta, b.nombres, a.idclie, a.vence, a.saldado, a.exentas+a.grav5+a.grav10+a.iva5+a.iva10 as total FROM vi_cabventas a inner join clientes b on a.idclie=b.idclie where a.tipofac=2 and a.saldado=0 and a.idclie=".$_GET['txt_idclie']." order by idventa desc limit 10";
              //var_dump($sql);
              $consulta=pg_query($con, $sql)or die ("Problemas en consulta ".pg_last_error ());                  
              while($ventas=pg_fetch_array($consulta)){
                
                $sql_pagos="SELECT sum(a.monto - a.interes) from detcobros a inner join cabcobros b on a.idcobro=b.idcobro where b.activo=1 and a.idventa=".$ventas['idventa'];
                $consulta_pagos=pg_query($con, $sql_pagos)or die ("Problemas en:".pg_last_error ());
                $sum_pagos=pg_fetch_array($consulta_pagos);
                if($sum_pagos[0] < $ventas['total']){
                  //saldo pendiente
                  $saldo= $ventas['total'] - $sum_pagos[0];                  
                  
            ?>
                <tr>                    
                    <td><?php echo number_format($ventas['nro'], 0, ',', '.'); ?></td>
                    <td><?php echo $ventas['falta']; ?></td>                    
                    <td><?php echo number_format($ventas['total'], 0, ',', '.'); ?></td>
                    <td><?php echo number_format($saldo, 0, ',', '.'); ?></td>
                    <td>
                        <a href="guardar_cobros.php?txt_cliente= <?php echo $_GET['txt_cliente']; ?>&txt_idclie=<?php echo $_GET['txt_idclie']; ?>&nro=<?php echo $ventas['nro'].','.$ventas['idventa'].','.$saldo; ?>&opcion=1" class="btn btn-info" >Agregar</a>
                    </td>
                </tr>
            <?php 
                } //end if pagos
              } //end while
            } //end if post  
              else{ ?>
                <tr>             
                    <td></td>
                    <td></td>
                    <td>Sin Registros</td>
                    <td></td>
                    <td></td>
                </tr>
            <?php }?>

            </tbody>

          </table>

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          --------------------------
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

<!-- REGISTRAR COBRO -->
<div class="modal fade" id="myModalCobro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Cobrar Facturas Nro:</h4>
      </div>

      <div class="modal-body">
      <?php 
        $sum_saldo=0;
        foreach ($_SESSION['lista_facturas'] as $v) {
          $part = explode(",", $v);
          //echo $part[0].'-'.$part[1].'-'.$part[2].'---';
           echo '<strong>'.$part[0].'<strong>  <a href="guardar_cobros.php?txt_cliente= '.$_GET['txt_cliente'].'&txt_idclie='.$_GET['txt_idclie'].'&nro='.$v.'&opcion=2" class="btn btn-danger" >Eliminar</a>, '; 
          $sum_saldo = $sum_saldo + $part[2];
         } 
      ?>
      <h4 class="my-2">Suma de saldos de facturas: <?php echo number_format($sum_saldo, 0, ',', '.'); ?></h4>
         <form name="form_cobros" id="form_cobros" method="post" action="guardar_cobros.php?opcion=3">
          <input id="idclie" name="idclie" type="hidden" value="<?php echo $_GET['txt_idclie']; ?>" />
          <input id="saldos" name="saldos" type="hidden" value="<?php echo $sum_saldo; ?>" />
          
          <div class="form-group">  
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

          </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button onclick="validar()" id="enviar" type="button" class="btn btn-success">Guardar</button>
      </form>
      </div>
    </div>
  </div>
</div><!-- </ REGISTRAR COBRO -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- buscador ui -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript"> 
function sepmiles(x) { return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."); }

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

$(function(){

  $("#txt_cliente").autocomplete({
    source: "buscar_clie.php",    
    minLength: 3,         
    select: registroSeleccionado, 
    focus: registroMarcado
  })

  function registroSeleccionado(event, ui){
      let registro = ui.item.value;  
      let descrip = registro.descripcion;
      let porcion = descrip.split('|');
      let mostrar =  porcion[0]+' | '+porcion[1]+' | '+porcion[2];
      $("#txt_idclie").val(registro.id);
      $("#txt_cliente").val(mostrar);
      
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

});
</script>