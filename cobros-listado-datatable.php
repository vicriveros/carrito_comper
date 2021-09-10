<?php 
include('_conexion.php');  
    
    $sql="SELECT a.idcobro, a.tipo as punto, a.nro, CAST(a.falta as date) as fecha, trim(b.nombres) as nombres, a.efectivo+a.cheque+a.chequead+a.tarjeta+a.anticip+a.depoban+a.girost as total FROM cabcobros a inner join clientes b on a.idclie=b.idclie where a.activo=1  order by idcobro desc";
    $consulta=pg_query($con, $sql)or die ("Problemas en consulta ".pg_last_error ());
    $cant=pg_num_rows($consulta);
    $i=1;
    $datosJson = '{
         "data": [';

        while($cobros=pg_fetch_array($consulta)){

                $botones = "<a href=cobros-imp.php?identificador='".$cobros['idcobro']."' target='_blank' name='cerrarf'  id='cerrarf' class='btn btn-info btn-confirmar-venta' style='margin-top:20px'>Imprimir</a>";
                $total = "<td style='text-align:right'>".number_format($cobros['total'], 0, ',', '.')."</td>";
                $datosJson .= '[
                    "' . ($i) . '",
                    "' . $cobros["idcobro"] . '",
                    "' . $cobros["punto"] . '",
                    "' . $cobros["nro"] . '",
                    "' . $cobros["fecha"] . '",
                    "' . $cobros["nombres"] . '",
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