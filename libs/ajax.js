function agregar_predeterminados(idart, producto){
	let cantidad = 25;
	let codigo = '';

	$.ajax({
		url: 'Controller/ProductoController.php?page=1',
		type: 'post',
		data: {'producto':producto, 'cantidad':cantidad, 'codigo':codigo, 'idart':idart},
		dataType: 'json'
	}).done(function(data){
		if(data.success==true){
			
			$("#txt_idart").val('');
			$("#txt_codigo").val('');
			$("#txt_cantidad").val('1');
			$("#txt_producto").val('');
			$("#txt_producto").focus();
			alertify.success(data.msj);
			$(".detalle-producto").load('detalle.php');
			$("#montoc").load('total.php');
			$("#montoVisor").load('total.php');
			
		}else{
			$("#txt_producto").focus();
			alertify.error(data.msj);
		}
	})
};

$(function(){ 
	$(".btn-agregar-producto").off("click");
	$(".btn-agregar-producto").on("click", function(e) {
		let idart = $("#txt_idart").val();
		let codigo = $("#txt_codigo").val();
		let cantidad = $("#txt_cantidad").val();
		let producto = $("#txt_producto").val();
		
		$.ajax({
			url: 'Controller/ProductoController.php?page=1',
			type: 'post',
			data: {'producto':producto, 'cantidad':cantidad, 'codigo':codigo, 'idart':idart},
			dataType: 'json'
		}).done(function(data){
			if(data.success==true){
				
				$("#txt_idart").val('');
				$("#txt_codigo").val('');
				$("#txt_cantidad").val('1');
				$("#txt_producto").val('');
				$("#txt_producto").focus();
				alertify.success(data.msj);
				$(".detalle-producto").load('detalle.php');
				$("#montoc").load('total.php');
				$("#montoVisor").load('total.php');
				
			}else{
				$("#txt_producto").focus();
				alertify.error(data.msj);
			}
		})
	});
	
	$(".eliminar-producto").off("click");
	$(".eliminar-producto").on("click", function(e) {
		var id = $(this).attr("id");
		$.ajax({
			url: 'Controller/ProductoController.php?page=2',
			type: 'post',
			data: {'id':id},
			dataType: 'json'
		}).done(function(data){
			if(data.success==true){
				console.log('paso')
				$("#txt_producto").focus();
				alertify.success(data.msj);
				$(".detalle-producto").load('detalle.php');
				$("#montoc").load('total.php');
				$("#montoVisor").load('total.php');
			}else{
				$("#txt_producto").focus();
				alertify.error(data.msj);
			}
		})
	});
	
	
	$(".guardar-edicion").off("click");
	$(".guardar-edicion").on("click", function(e) {
		let id = $(this).attr("id");
		let idcarro = $(`#editar_id${id}`).val();
		let idart = $(`#editar_articulo${id}`).val();
		let codigo = $(`#editar_codigo${id}`).val();
		let producto = $(`#editar_producto${id}`).val();
		let cantidad = $(`#editar_cantidad${id}`).val();
		let precio = $(`#editar_precio${id}`).val();
		let descuento = $(`#editar_descuento${id}`).val();

		$.ajax({
			url: 'Controller/ProductoController.php?page=3',
			type: 'post',
			data: {'producto':producto, 'cantidad':cantidad, 'codigo':codigo, 'idart':idart, 'precio':precio, 'descuento':descuento, 'id':idcarro},
			dataType: 'json'
		}).done(function(data){
			if(data.success==true){
				$("#txt_idart").val('');
				$("#txt_codigo").val('');
				$("#txt_cantidad").val('1');
				$("#txt_producto").val('');
				$("#txt_producto").focus();
				alertify.success(data.msj);
				$(".detalle-producto").load('detalle.php');
				$("#montoc").load('total.php');
				$("#montoVisor").load('total.php');
			}else{
				alertify.error(data.msj);
			}
		})
		
	});
	
});