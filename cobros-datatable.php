<?php 
include('_conexion.php');  
    if($_POST['idclie']>0){
        
        $sql="SELECT a.idventa, a.timb as punto, a.nro, CAST(a.falta AS date), trim(b.nombres) as nombres, a.tipofac, a.exentas+a.grav5+a.grav10+a.iva5+a.iva10 as total FROM vi_cabventas a inner join clientes b on a.idclie=b.idclie where saldado=0 and tipofac=2 and a.idclie= ".$_POST['idclie']." order by idventa desc";
        $consulta=pg_query($con, $sql)or die ("Problemas en consulta ".pg_last_error ());
        $cant=pg_num_rows($consulta);

        if($cant>0){

            $ingresa=0;

            $datosJson = '{
                "data": [';
    
                while($ventas=pg_fetch_array($consulta)){
                    $sql_pagos="SELECT sum(monto - interes) from detcobros where idventa=".$ventas['idventa'];
                    $consulta_pagos=pg_query($con, $sql_pagos)or die ("Problemas en:".pg_last_error ());
                    $sum_pagos=pg_fetch_array($consulta_pagos);
                    //saldo pendiente
                    $saldo= $ventas['total'] - $sum_pagos[0];
                    $parametros = $ventas["idventa"].",".$ventas["nro"].",'".$ventas["falta"]."',".$ventas["total"].",".$saldo;
                    if($saldo>0){
                        $ingresa=1;
                        $botones = "<td> <button type='button' onclick='agregar_factura(".$ventas["idventa"].",".$ventas["nro"].",".$ventas["total"].",".$saldo.")' class='btn btn-info' >Agregar</button> </td>";
                        $total = "<td style='text-align:right'>".number_format($ventas['total'], 0, ',', '.')."</td>";
                        $csaldo = "<td style='text-align:right'>".number_format($saldo, 0, ',', '.')."</td>";
                            $datosJson .= '[
                                "' . $ventas["nro"] . '",
                                "' . $ventas["falta"] . '",
                                "' . $total . '",
                                "' . $csaldo . '",
                                "' . $botones . '"
                            ],';
                    }
                    if($ingresa==0){
 
                        
                            $datosJson .= '[
                                " SIN ",
                                " FACTURAS PENDIENTES ",
                                "  ",
                                "  ",
                                "  "
                            ],';
                    
                    
                    };

            };
            $datosJson = substr($datosJson, 0, -1);
    
            $datosJson .=   '] 
    
            }';
            
            echo $datosJson;

        }else{
                    
            
            $datosJson = '{
                "data": [';
            
                $datosJson .= '[
                    " SIN ",
                    " FACTURAS PENDIENTES ",
                    "  ",
                    "  ",
                    "  "
                ],';
        
        
                $datosJson = substr($datosJson, 0, -1);
        
                $datosJson .=   '] 
        
                }';
                
                echo $datosJson;
        }
        
    }else{        
        $datosJson = '{
            "data": [';
        
            $datosJson .= '[
                " SIN ",
                " FACTURAS PENDIENTES ",
                "  ",
                "  ",
                "  "
            ],';
    
    
            $datosJson = substr($datosJson, 0, -1);
    
            $datosJson .=   '] 
    
            }';
            
            echo $datosJson;

    };
?>