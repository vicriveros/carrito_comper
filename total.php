<?php 
session_start();
   	    	
			$totgral=0;
	    	foreach($_SESSION['detalle'] as $k => $detalle){ 
				$totgral=$totgral+$detalle['total'];
			}
	    	?>
			<h1 class="card-title" style="color:#060;">Importe: <?php echo number_format($totgral, 0, ',', '.'); ?> Gs.</h1>
			<input id="txt_tot" name="txt_tot" type="hidden" value="<?php echo $totgral; ?>" />
