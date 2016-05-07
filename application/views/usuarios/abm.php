<?php
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

$entes_array = array();

if($entes_asoc){
	foreach ($entes_asoc as $row) {
		$entes_array[] = $row->id_ente;
	}
}

/*--------------------------------------------------------------------------------	
 			Carga de select
 --------------------------------------------------------------------------------*/

if($entes){
	$opciones_entes = setOption($entes, 'id_ente', 'nombre', $entes_array);
}else{
	$opciones_entes = '<option></option>';
}	


/*--------------------------------------------------------------------------------	
 			Contenido
 --------------------------------------------------------------------------------*/
?>
<script src=<?php echo base_url().'librerias/multiselect/js/jquery.multi-select.js'?>></script>
<link href="<?php echo base_url()?>librerias/multiselect/css/multi-select.css" rel="stylesheet">

<section class="content">
	<div class="row">
		<section class="col-lg-12 connectedSortable">
			<form class="form-horizontal" method="post" action="<?php echo base_url().'index.php/'.$subjet.'/abm/'?>">
			<div class="box box-info">
				<div class="box-body">
					<?php
						if($registro_values['id_perfil'] == 2){
					?>
					<div class="tabbable">
						<ul class="nav nav-tabs">
						<?php 
						foreach ($secciones as $row) {
							if($row == $seccion){
								echo '<li class="active"><a href="#tab_'.$row.'" data-toggle="tab">'.$this->lang->line($row).'</a></li>';
								$class_pane[$row] = 'tab-pane active divider';
							}else{
								echo '<li><a href="#tab_'.$row.'" data-toggle="tab">'.$this->lang->line($row).'</a></li>';
								$class_pane[$row] = 'tab-pane divider';
							}
						}
						?>
						</ul>
					  	<div class="tab-content">
					    	<div class="<?php echo $class_pane['usuario']?>" id="tab_usuario">
				    <?php
						}
					?>
								<div class="form-group">
									<div class="col-sm-3"></div>
									<?php echo setLabel($this->lang->line('usuario'), 2);?>
									<div class="col-sm-4">
										<input <?php echo completar_tag('usuario', $registro_values, 'onlyCharInt');?> autofocus onfocusout="control_usuarios()" required>
									</div>
									<div class="col-sm-3"></div>
								</div>
								
								<div class="form-group">
									<div class="col-sm-3"></div>
									<?php echo setLabel($this->lang->line('contraseña'), 2);?>
									<div class="col-sm-4">
										<input <?php echo completar_tag('pass', decrypt($registro_values['pass']), 'onlyCharInt');?> required>
									</div>
									<div class="col-sm-3"></div>
								</div>
								<div class="form-group">
									<div class="col-sm-3"></div>
									<?php echo setLabel($this->lang->line('perfil'), 2);?>
									<div class="col-sm-4">
										<?php 
										if($perfiles){
											if($registro_values['id_perfil'] == ''){
												foreach ($perfiles as $row) {
													if (2 == $row->id_perfil){
														echo '<label class="radio-inline"><input type="radio" name="id_perfil" value="'.$row->id_perfil.'" checked required> '.$row->perfil.'</label>';
													}else{
														echo '<label class="radio-inline"><input type="radio" name="id_perfil" value="'.$row->id_perfil.'" required> '.$row->perfil.'</label>';
													}
												}	
											}else{
												foreach ($perfiles as $row) {
													if( $registro_values['id_perfil'] == $row->id_perfil){
														echo '<label class="radio-inline"><input type="radio" name="id_perfil" value="'.$row->id_perfil.'" checked required> '.$row->perfil.'</label>';
													}else{
														echo '<label class="radio-inline"><input type="radio" name="id_perfil" value="'.$row->id_perfil.'" required> '.$row->perfil.'</label>';
													}
												}	
											}	
										}
										?>
									</div>
									<div class="col-sm-3"></div>
								</div>
								<div class="alert alert-danger alert-dismissable divider" id="alert" style="display: none;">
									<div id="mensaje_error"></div>
                 				</div>
							
				    <?php
						if($registro_values['id_perfil'] == 2){
					?>	
							</div>
							<div class="<?php echo $class_pane['entes']?>" id="tab_entes">
								<?php 
								if(isset($mensajes)){
				    				echo setMensaje($mensajes, 'ok');
				    			}
								?>
								<div class="row divider">
									<?php echo setLabel($this->lang->line('asociar').' '.$this->lang->line('entes'), 2) ?>
									<div class="col-md-9">
		                    			<select class="form-control" name="entes[]" id="entes" multiple/>
		                    				<?php echo $opciones_entes?>
										</select>
									</div>
									<div class="col-md-1">
										<button type="button" class="btn btn-default" id="select-all"><i class="fa fa-arrow-right"></i></button>
										<button type="button" class="btn btn-default divider" id="deselect-all"><i class="fa fa-arrow-left"></i></button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
						}
				    ?>
				</div>
				<div class="box-footer">
					<div class="form-group">
						<div class="col-sm-12 text-center">
								<?php
								echo '<input name="id_usuario" id="id_usuario" type="hidden" value="'.$registro_values['id_usuario'].'">';
								 
								if(!$registro && $permisos['agregar'] == 1){
									echo button_add();
								}else{
									if($registro_values['eliminado'] == 0){
										if($permisos['modificar'] == 1){
											echo button_upd();
										}
										
										if($permisos['eliminar'] == 1 && $registro_values['id_usuario'] != $session_data['id_usuario']){
											echo button_dlt();
										}
									} else {
										if($permisos['eliminar'] == 1){
											echo button_res();
										}
									}
								} 
								?>
						</div>
					</div>		
				</div>
			</div>
			</form>
		</section>
	</div>

</section>

<script>
$(function() {
	$('#entes').multiSelect();
	
	$('#select-all').click(function(){
		$('#entes').multiSelect('select_all');
		$('#entes').multiSelect('refresh');
		return false;
	});
	
	$('#deselect-all').click(function(){
		$('#entes').multiSelect('deselect_all');
		$('#entes').multiSelect('refresh');
		return false;
	});

});



function control_usuarios(){
	var usuario = $('#usuario').val();
	var id_usuario = $('#id_usuario').val();
 	$.ajax({
	 	type: 'POST',
	 	url: '<?php echo base_url(); ?>index.php/usuarios/control_usuarios/',
	 	data: { usuario: usuario, id_usuario: id_usuario},
	 	success: function(resp) { 
	 		if(resp == 0){
	 			$('#usuario').focus();
	 			$('#usuario').val() == '';
	 			$('#alert').show( "drop", 1000 );
	 			$('#mensaje_error').html('<p>El usuario ya existe</p>');
	 		}else if(resp == 2){
	 			$('#usuario').focus();
	 			$('#alert').show( "drop", 1000 );
	 			$('#mensaje_error').html('<p>Complete usuario</p>');
	 		}else{
	 			$('#alert').hide( "drop", 1000 );
	 		}
	 	}
	});
}
</script>