<?php
/*--------------------------------------------------------------------------------	
 			Carga de array necesarios
 --------------------------------------------------------------------------------*/	
	
if($fields){
	foreach ($fields as $field) {
		$registro_values[$field] = '';
	}
}

if($extra_fields){
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

if($provincias){
	$opciones_provincias = setOption($provincias, 'id_provincia', 'provincia', $registro_values['id_provincia']);
}else{
	$opciones_provincias = '<option></option>';
}


echo start_content();

if(isset($mensaje)){
	echo setMensaje($mensaje);
}

?>
<form action="#" method="post" class="form-horizontal">
	<div class="form-group">
		<!-- Codigo -->
		<?php echo setLabel($this->lang->line('codigo'));?>
		<div class="col-sm-5">
			<div class="input-group">
				<input <?php echo completar_tag('codigo', $registro_values, '[99999999999]');?> onfocusout="buscar_codigo()" required>
				<span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
			</div>
		</div>
	</div>
						
	<div class="form-group">
		<!-- NOMBRE -->
		<?php echo setLabel($this->lang->line('nombre'));?>
		<div class="col-sm-5">
			<div class="input-group">
				<input <?php echo completar_tag('nombre', $registro_values, 'onlyChar');?> autofocus required>
				<span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
			</div>
		</div>
		<!-- APELLIDO -->
		<?php echo setLabel($this->lang->line('apellido'));?>
		<div class="col-sm-5">
			<div class="input-group">
				<input <?php echo completar_tag('apellido', $registro_values, 'onlyChar');?> required>
				<span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
			</div>
		</div>
	</div>
                    	
	<div class="form-group">
		<!-- CALLE -->
		<?php echo setLabel($this->lang->line('calle'));?>
		<div class="col-sm-5">
			<div class="input-group">
				<input <?php echo completar_tag('calle', $registro_values, 'onlyCharInt');?> required>
				<span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
			</div>
		</div>
		<!-- NUMERO DE CALLE -->
		<?php echo setLabel($this->lang->line('nro'));?>
		<div class="col-sm-1">
			<input <?php echo completar_tag('numero', $registro_values, 'onlyInt');?>>
		</div>
		<!-- PISO -->
		<?php echo setLabel($this->lang->line('piso'));?>
		<div class="col-sm-1">
			<input <?php echo completar_tag('piso', $registro_values, 'onlyInt');?>>
		</div>
		<!-- DEPARTAMENTO -->
		<?php echo setLabel($this->lang->line('depto'));?>
		<div class="col-sm-1">
			<input <?php echo completar_tag('departamento', $registro_values, 'onlyCharInt');?>>
		</div>
	</div>
                    	
	<div class="form-group">
		<!-- PROVINCIA -->
		<?php echo setLabel($this->lang->line('provincia'));?>
		<div class="col-sm-5">
			<div class="input-group">
				<select name="id_provincia" id="provincia" class="form-control" onchange="provincias_activas()" required>
					<?php echo $opciones_provincias ?>
				</select>
				<span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
			</div>
		</div>
		<!-- LOCALIDAD -->
		<?php echo setLabel($this->lang->line('localidad'));?>
		<div class="col-sm-5">
			<select name="id_localidad" id="localidad" class="form-control" disabled  onchange="set_localidad()">
				<option></option>
			</select>
		</div>
	</div>
                    	
	<div class="form-group">
		<!-- CODIGO POSTAL -->
		<?php echo setLabel($this->lang->line('codigo_postal'));?>
		<div class="col-sm-5">
			<input <?php echo completar_tag('codigo_postal', NULL, 'onlyInt');?> disabled>
		</div>
		<?php if($registro){ ?>
		<!-- FECHA DE INGRESO DEL REGISTRO -->
		<?php echo setLabel($this->lang->line('date_add'));?>
		<div class="col-sm-5">
			<input <?php echo completar_tag('date_add', formatDatetime($registro_values['date_add']));?> disabled>
		</div>
   		<?php } ?>
	</div>
                    	
	<div class="form-group">
		<!-- TELEFONO -->
		<?php echo setLabel($this->lang->line('telefono'));?>
		<div class="col-sm-5">
			<input <?php echo completar_tag('telefono', $registro_values, '(999) 999-9999[9]');?>>
		</div>
		<?php if($registro){ ?>
		<!-- FECHA DE ACTUALIZACION DEL REGISTRO -->
		<?php echo setLabel($this->lang->line('date_upd'));?>
		<div class="col-sm-5">
			<input <?php echo completar_tag('date_add', formatDatetime($registro_values['date_upd']));?> disabled>
		</div>
		<?php } ?>
	</div>
                    	
	<div class="form-group">
		<!-- EMAIL -->
		<?php echo setLabel($this->lang->line('email'));?>
		<div class="col-sm-5">
			<div class="input-group" data-validate="email">
				<input <?php echo completar_tag('email', $registro_values);?> required>
				<span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
			</div>
		</div>
	</div>
                    	
	<div class="form-group">
		<div class="col-md-12 text-center">
		<?php 
			echo '<input name="id_ente" id="id_ente" type="hidden" value="'.$session_data['id_ente'].'">';	
			   					
			//-- AGREGAR REGISTRO --
			if(!$registro){
				echo '<input name="id_afiliado" id="id_afiliado" type="hidden" value="0">';	
  				echo button_add();
				echo button_add('permanecer');
			//- ACTUALIZAR REGISTRO --
			}else{
				echo '<input name="id_afiliado" id="id_afiliado" type="hidden" value="'.$registro_values['id_afiliado'].'">';	 
				
				if($registro_values['eliminado'] == 0){
					if($permisos['modificar'] == 1){
						echo button_upd();
					}
					
					if($permisos['eliminar'] == 1){
						echo button_dlt();
					}
				} else {
					if($permisos['eliminar'] == 1){
						echo button_res();
					}
				}

				if($session_data['boletas'] == 1){
					$button = '<a class="btn btn-app" href="'.base_url().'index.php/boletas/table/'.$registro_values['id_afiliado'].'">';
					$button	.= '<i class="fa fa-file-text-o"></i>';
					$button	.= $this->lang->line('boletas');
					$button	.= '</a>';
					
					echo $button;	
				}	
				
				if($session_data['tarjetas'] == 1){
					$button = '<a class="btn btn-app" href="'.base_url().'index.php/tarjetas/abm/'.$registro_values['id_afiliado'].'">';
					$button	.= '<i class="fa fa-credit-card"></i>';
					$button	.= $this->lang->line('tarjetas');
					$button	.= '</a>';
					
					echo $button;	
				}			
			}
		?>
        </div>
	</div>
</form>

<div class="alert alert-danger alert-dismissable divider" id="alert_form" style="display: none;">
	<div id="mensaje_error"></div>
</div>

<?php 
	echo end_content();
?>

<script>

$("[data-inputmask]").inputmask();



function provincias_activas(){
	var provincia = $('select#provincia').val(); //Obtenemos el id de la provincia seleccionada en la lista
 	$.ajax({
	 	type: 'POST',
	 	url: '<?php echo base_url(); ?>index.php/afiliados/getLocalidades/', //Realizaremos la petición al metodo prueba del controlador direcciones
	 	<?php 
	 	if($registro){
	 	?>
	 	data: { id_localidad: <?php echo $registro_values['id_localidad'] ?>, provincia: provincia }, //Pasaremos por parámetro POST el id de la provincia
	 	<?php }else{ ?>
	 	data: 'provincia='+provincia, 
	 	<?php } ?>
	 	success: function(resp) { //Cuando se procese con éxito la petición se ejecutará esta función
	 		//Activar y Rellenar el select de departamentos
	 		$('select#localidad').attr('disabled',false).html(resp); //Con el método ".html()" incluimos el código html devuelto por AJAX en la lista de provincias
	 		$('select#localidad').focus();
	 	}
	});
};



function set_localidad(){
	var localidad = $('select#localidad').val();
 	$.ajax({
	 	type: 'POST',
	 	url: '<?php echo base_url(); ?>index.php/afiliados/getCodPostal/',
	 	data: 'localidad='+localidad, 
	 	success: function(resp) { 
	 		$('#codigo_postal').attr('disabled',false);
	 		$('#codigo_postal').val(resp);
	 		$('#telefono').focus();
	 	}
	});
}



function buscar_codigo(){
	var codigo = $('#codigo').val();
	var id_ente = $('#id_ente').val();
	var id_afiliado = $('#id_afiliado').val();
 	$.ajax({
	 	type: 'POST',
	 	url: '<?php echo base_url(); ?>index.php/afiliados/getCodigo/',
	 	data: { codigo: codigo, id_ente: id_ente, id_afiliado: id_afiliado},
	 	success: function(resp) { 
	 		if(resp == 0){
	 			$('#codigo').focus();
	 			$('#alert_form').show( "drop", 1000 );
	 			$('#modificar').prop('disabled', true);
	 			$('#mensaje_error').html('<p>El código ya existe</p>');
	 		}else if(resp == 2){
	 			$('#codigo').focus();
	 			$('#alert_form').show( "drop", 1000 );
	 			$('#mensaje_error').html('<p>Complete codigo</p>');
	 		}else{
	 			$('#alert_form').hide( "drop", 1000 );
	 		}
	 	}
	});
}
</script>