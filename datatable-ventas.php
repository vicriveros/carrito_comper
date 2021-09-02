<?php 
include('_conexion.php');  

    $sql="SELECT a.idventa, a.nro, a.falta, trim(b.nombres) as nombres, a.exentas+a.grav5+a.grav10+a.iva5+a.iva10 as total FROM vi_cabventas a inner join clientes b on a.idclie=b.idclie where a.idtimb!=0  order by idventa desc";
    $ventas = pg_query ($con, $sql) or die ("Problemas en $-campos:".pg_last_error ());
    
    //for ($i = 0; $i < count($ventas); $i++) {

    $datosJson = '{
         "data": [';
    
        while($ventas=pg_fetch_array($ventas)){

                $botones = "<a href=imp.php?identificador=".$ventas['idventa']." target=_parent name=cerrarf  id=cerrarf class=btn btn-info btn-confirmar-venta style=margin-top:20px;>Imprimir</a>";

                $datosJson .= '[
                    "' . ($i + 1) . '",
                    "' . $ventas["idventa"] . '",
                    "' . $ventas["nro"] . '",
                    "' . $ventas["falta"] . '",
                    "' . $ventas["nombres"] . '",
                    "' . $ventas["total"] . '",
                    "' . $botones . '"
                ],';

        }

    $datosJson = substr($datosJson, 0, -1);

    $datosJson .=   '] 

     }';
    
    echo $datosJson;

?>