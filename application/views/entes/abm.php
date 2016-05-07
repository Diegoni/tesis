<?php
echo js_libreria('plugins/input-mask/jquery.inputmask.js');
echo js_libreria('plugins/input-mask/jquery.inputmask.date.extensions.js');
echo js_libreria('plugins/input-mask/jquery.inputmask.extensions.js');

echo css_libreria('plugins/bootstrap-switch-master/dist/css/bootstrap3/bootstrap-switch.css');
echo js_libreria('plugins/bootstrap-switch-master/dist/js/bootstrap-switch.js');

/*--------------------------------------------------------------------------------	
 			Carga de array necesarios
 --------------------------------------------------------------------------------*/	
	
if($fields){
	foreach ($fields as $field) {
		$registro_values[$field] = '';
	}
}

if(isset($extra_fields)){
	foreach ($extra_fields as $field) {
		$registro_values[$field] = '';
	}
}
		
if($registro){
	foreach ($registro as $row) {
		$registro_values = (array) $row;
	}
}

if($cod_inc){
	$registro_values['codigo'] = $cod_inc['codigo'] + 1;
}

/*--------------------------------------------------------------------------------	
 			Carga de opciones en los select
 --------------------------------------------------------------------------------*/	

if($leyendas){
	$opciones_leyendas = setOption($leyendas, 'id_leyenda', 'leyenda', $registro_values['id_leyenda']);
}else{
	$opciones_leyendas = '<option></option>';
}

if($leyendas){
	$opciones_convenios = setOption($convenios, 'id_convenio', 'convenio', $registro_values['id_convenio']);
}else{
	$opciones_convenios = '<option></option>';
}

/*--------------------------------------------------------------------------------	
 			Contenido del sitio
 --------------------------------------------------------------------------------*/	

echo start_content();

if(isset($mensaje)){
	echo setMensaje($mensaje, 'error');
}
?>
<form action="#" method="post" class="form-horizontal" onsubmit="return control_check()">
	<div class="form-group divider">
		<!-- CODIGO -->
		<?php echo setLabel($this->lang->line('codigo'));?>
		<div class="col-sm-5">
			<div class="input-group">
				<input <?php echo completar_tag('codigo', $registro_values, 'onlyInt');?> onfocusout="buscar_codigo()" required>
				<span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
			</div>
		</div>
	                   			
		<!-- NOMBRE -->
		<?php echo setLabel($this->lang->line('nombre'));?>
		<div class="col-sm-5">
			<div class="input-group">
				<input <?php echo completar_tag('nombre', $registro_values, 'onlyCharInt');?> autofocus required>
				<span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<!-- CUIT -->
		<?php echo setLabel($this->lang->line('cuit'));?>
		<div class="col-sm-5">
			<div class="input-group" data-validate="cuit">
				<input <?php echo completar_tag('cuit', $registro_values, '99-99999999-9');?> onfocusout="validarCuit()" required>
				<span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
			</div>
		</div>
	                   			
		<!-- TELEFONO -->
		<?php echo setLabel($this->lang->line('telefono'));?>
		<div class="col-sm-5">
			<div class="input-group">
				<input <?php echo completar_tag('telefono', $registro_values, '(999) 999-9999[9]');?> required>
				<span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<!-- LEYENDA -->
		<?php echo setLabel($this->lang->line('leyenda'));?>
		<div class="col-sm-5">
			<div class="input-group">
				<select name="id_leyenda" class="form-control" required><?php echo $opciones_leyendas?></select>
				<span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
			</div>
		</div>
		
		<!-- CONVENIOS -->
		<?php echo setLabel($this->lang->line('convenio'));?>
		<div class="col-sm-5">
			<div class="input-group">
				<select name="id_convenio" class="form-control" required><?php echo $opciones_convenios?></select>
				<span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<!-- COMENTARIO -->
		<?php echo setLabel($this->lang->line('comentarios'));?>
		<div class="col-sm-11">
			<textarea name="comentario" class="form-control" placeholder="<?php echo $this->lang->line('comentarios');?>"><?php echo $registro_values['comentario']?></textarea>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo setCheckbox('bloquear',		$registro_values, 1)?>
	</div>	

	<div class="alert alert-danger alert-dismissable divider" id="alert" style="display: none;">
		<div id="mensaje_error"></div>
	</div>

	<hr>
	<div class="form-group">
		<?php echo setCheckbox('boletas',		$registro_values)?>
		<?php echo setCheckbox('tarjetas',		$registro_values)?>
	</div>	
	<hr>
	<div class="form-group">
		<div class="col-sm-12 text-center">
		<?php 
		if(!$registro){
			echo '<input name="id_ente" id="id_ente" type="hidden" value="0">';
			
			if($permisos['agregar'] == 1){
				echo button_add();
			}
		} else {
			echo '<input name="id_ente" id="id_ente" type="hidden" value="'.$registro_values['id_ente'].'">';
			
			if($registro_values['eliminado'] == 0){
				if($permisos['modificar'] == 1){
					echo button_upd();
				}
				
				if($permisos['eliminar'] == 1){
					echo button_dlt();
				}
			}
		}
		?>
		</div>
	</div>
</form>
<?php
echo end_content()
?>
<script>
$("[data-inputmask]").inputmask();



function buscar_codigo(){
	var codigo = $('#codigo').val();
	var id_ente = $('#id_ente').val();
 	$.ajax({
	 	type: 'POST',
	 	url: '<?php echo base_url(); ?>index.php/entes/getCodigo/',
	 	data: { codigo: codigo, id_ente: id_ente },
	 	success: function(resp) { 
	 		if(resp == 0){
	 			$('#codigo').focus();
	 			$('#alert').show( "drop", 1000 );
	 			$('#modificar').prop('disabled', true);
	 			$('#mensaje_error').html('<p>El código ya existe</p>');
	 		}else if(resp == 2){
	 			$('#codigo').focus();
	 			$('#alert').show( "drop", 1000 );
	 			$('#mensaje_error').html('<p>Complete codigo</p>');
	 		}else{
	 			$('#alert').hide( "drop", 1000 );
	 		}
	 	}
	});
}



function validarCuit(){
	var cuit = $('#cuit').val();
	var cuit_error = cuit.slice(0,-1)
	var mensaje = $('#mensaje_error').html();
	var error = '<p>El cuit no es válido</p>';
	if(cuit == ''){
		$('#cuit').focus();
	}else if(mensaje != '' && mensaje != error && cuit != ''){
		$('#codigo').focus();
	}else{
		$.ajax({
		 	type: 'POST',
		 	url: '<?php echo base_url(); ?>index.php/entes/validarCuit/',
		 	data: { cuit: cuit },
		 	success: function(resp) { 
		 		if(resp == 0){
		 			$('#cuit').focus();
		 			$('#alert').show( "drop", 1000 );
		 			$('#modificar').prop('disabled', true);
		 			$('#mensaje_error').html(error);
		 			$('#agregar').prop('disabled', true);
		 		}else{
		 			$('#alert').hide( "drop", 1000 );
		 		}
		 	}
		});
	}
}



function control_check(){
	var bandera = 0;
	$('.checkbox').each(function(){ 
		if(this.checked){
			bandera = 1;
		}
	});
	
	if(bandera == 1){
		return true;
	}else{
		$('#alert').show( "drop", 1000 );
		$('#boletas').focus();
		$('#mensaje_error').html('Debe seleccionar al menos una opción');
		
		
		var variable = $('#modificar');
		variable.button('loading');
		setTimeout(function() {
			variable.button('reset');
			}, 
			400);

		return false;	
	}
};



$('.bootstrap-switch-container').click(function(){ 
	alert('test');
});

$('.checkbox').each(function(){ 
	if(this.value == 1){
		this.checked = true;
	}
});

$(".checkbox").bootstrapSwitch();
</script>