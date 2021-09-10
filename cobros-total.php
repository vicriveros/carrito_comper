<?php 
session_start();
   	    	
			$totgral=0;
	    	foreach($_SESSION['detcobros'] as $k => $detalle){ 
				$totgral=$totgral+$detalle['pagar'];
			}
	    	?>
			<h1 class="card-title" style="color:#060;">Importe: <?php echo number_format($totgral, 0, ',', '.'); ?> Gs.</h1>
			<input id="saldos" name="saldos" type="hidden" value="<?php echo $totgral; ?>" />
