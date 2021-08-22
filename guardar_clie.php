<?php 
include('_conexion.php');
//Registrar o actualizar cliente
    //variables POST
      $nombre=$_POST['nombre'];
      $ruc=$_POST['ruc'];
      $tel=$_POST['telefono'];
      $direc=$_POST['direccion'];
      $barrio=$_POST['barrio'];
      $ubicacion=$_POST['ubicacion'];
    
     $sql1="select idclie from clientes where ruc like '".$ruc."%'";
     $datos1 = pg_query ($con, $sql1) or die ("Problemas en select:".pg_last_error ());
     $can=pg_num_rows($datos1);
    
    if ($can > 0) {
        //actualizar datos
        $dt=pg_fetch_array($datos1);
        $sql="update clientes set nombres='".$nombre."',
         ruc='".$ruc."',
         telefono='".$tel."',
         barrio='".$barrio."',
         ubicacion='".$ubicacion."',
         direccion='".$direc."'
         where idclie=".$dt['idclie'];
        $datos = pg_query ($con, $sql) or die ("Problemas en $-campos:".pg_last_error ());
        $nextid= $dt['idclie'];
    
    }else{
    //registrar cliente
    $ult = pg_query ($con, "select max(idclie) from clientes") or die ("Problemas en $-campos:".pg_last_error ());
    $uid= pg_fetch_array($ult);
    $nextid= $uid[0]+1;

    $sql="insert into clientes (idclie, nombres, ruc, telefono, direccion, barrio, ubicacion)
        values ('".$nextid."', '".$nombre."', '".$ruc."', '".$tel."', '".$direc."', '".$barrio."', '".$ubicacion."')";
    $datos = pg_query ($con, $sql) or die ("Problemas en $-campos:".pg_last_error ());
 
    } //registrar cliente

    echo '<script>location.href="cabecera.php?clie_id='.$nextid.'";</script>';
    
?>