<?php 
include('_conexion.php');  
    
    $sql="SELECT a.idventa, a.timb as punto, a.nro, a.falta, trim(b.nombres) as nombres, a.tipofac, a.exentas+a.grav5+a.grav10+a.iva5+a.iva10 as total FROM vi_cabventas a inner join clientes b on a.idclie=b.idclie where a.idtimb!=0  order by idventa desc";
    $consulta=pg_query($con, $sql)or die ("Problemas en consulta ".pg_last_error ());
    $cant=pg_num_rows($consulta);
    $i=1;
    $datosJson = '{
         "data": [';

        while($ventas=pg_fetch_array($consulta)){

                $botones = "<a href=imp.php?identificador='".$ventas['idventa']."' target='_blank' name='cerrarf'  id='cerrarf' class='btn btn-info btn-confirmar-venta' style='margin-top:20px'>Imprimir</a>";
                
                if($ventas["tipofac"]=='1'){
                    $tipofac = 'CONTADO';
                }else{
                    $tipofac = 'CREDITO';
                }
                $total = "<td style='text-align:right'>".number_format($ventas['total'], 0, ',', '.')."</td>";
                $datosJson .= '[
                    "' . ($i) . '",
                    "' . $ventas["idventa"] . '",
                    "' . $ventas["punto"] . '",
                    "' . $ventas["nro"] . '",
                    "' . $tipofac . '",
                    "' . $ventas["falta"] . '",
                    "' . $ventas["nombres"] . '",
                    "' . $total . '",
                    "' . $botones . '"
                ],';
                $i=$i+1;
        }

    $datosJson = substr($datosJson, 0, -1);

    $datosJson .=   '] 

     }';
    
    echo $datosJson;

?>