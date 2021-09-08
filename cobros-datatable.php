<?php 
include('_conexion.php');  
    if($_POST['idclie']>0){
        
        $sql="SELECT a.idventa, a.timb as punto, a.nro, a.falta, trim(b.nombres) as nombres, a.tipofac, a.exentas+a.grav5+a.grav10+a.iva5+a.iva10 as total FROM vi_cabventas a inner join clientes b on a.idclie=b.idclie where saldado=0 and tipofac=2 and a.idclie= ".$_POST['idclie']." order by idventa desc";
        $consulta=pg_query($con, $sql)or die ("Problemas en consulta ".pg_last_error ());
        $cant=pg_num_rows($consulta);

        if($cant>0){

            
            $datosJson = '{
                "data": [';
    
                while($ventas=pg_fetch_array($consulta)){
    
                        $botones = "<td><a href='#' class='btn btn-info' >Total</a><a href='#' class='btn btn-warning' >Parcial</a></td>";
    
                        $datosJson .= '[
                            "' . $ventas["idventa"] . '",
                            "' . $ventas["nro"] . '",
                            "' . $ventas["falta"] . '",
                            "' . $ventas["total"] . '",
                            "' . $ventas["total"] . '",
                            "' . $botones . '"
                        ],';
                }
    
            $datosJson = substr($datosJson, 0, -1);
    
            $datosJson .=   '] 
    
            }';
            
            echo $datosJson;

        }else{
                    
            
            $datosJson = '{
                "data": [';
            
                $datosJson .= '[
                    "  ",
                    " SIN ",
                    " REGISTROSs ",
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
                "  ",
                " SIN ",
                " REGISTROS ",
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