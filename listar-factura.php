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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-">
            <h1>Listado de Facturas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="cabecera.php">Home</a></li>
              <li class="breadcrumb-item active">Listado de Facturas</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

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

          <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
            <thead>

              <tr>
                <th style="width:5px">ID</th>
                <th>Nro.</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Monto</th>
                <th>Acciones</th>
              </tr>

            </thead>

            <tbody>
            <?php 
                // var_dump($_SESSION['login_vendedor']);
              $sql="SELECT a.idventa, a.nro, a.falta, b.nombres, a.exentas+a.grav5+a.grav10+a.iva5+a.iva10 as total FROM vi_cabventas a inner join clientes b on a.idclie=b.idclie where a.idvend=".$_SESSION['login_vendedor']. " order by idventa desc limit 10";
              //var_dump($sql);
              $consulta=pg_query($con, $sql)or die ("Problemas en consulta ".pg_last_error ());
              $cant=pg_num_rows($consulta);
              //$ventas=pg_fetch_array($consulta);

                while($ventas=pg_fetch_array($consulta)){

            ?>
                <tr>
                    <td><?php echo number_format($ventas['idventa'], 0, ',', '.'); ?></td>
                    <td><?php echo number_format($ventas['nro'], 0, ',', '.'); ?></td>
                    <td><?php echo $ventas['falta']; ?></td>
                    <td><?php echo $ventas['nombres']; ?></td>
                    <td><?php echo number_format($ventas['total'], 0, ',', '.'); ?></td>
                    <td>

                        <a href="imp.php?identificador=<?php echo $ventas['idventa'] ?>" target="_parent" name="cerrarf"  id="cerrarf" class="btn btn-info btn-confirmar-venta" style="margin-top:20px;">Imprimir</a>

                    </td>
                </tr>
            <?php 
                    }              
            ?>

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

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>