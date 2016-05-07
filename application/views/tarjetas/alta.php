<?php
echo '<script src="'.base_url().'librerias/multiselect/js/jquery.multi-select.js"></script>';
echo '<link href="'.base_url().'librerias/multiselect/css/multi-select.css" rel="stylesheet">';

$afiliados_array = array();

if($tarjetas){
	foreach ($tarjetas as $row) {
		$afiliados_array[] = $row->id_afiliado;
	}
}

if($afiliados){
	foreach ($afiliados as $key => $row) {
		if(in_array($row->id_afiliado, $afiliados_array)){
			unset($afiliados[$key]);
		}
	}
}

/*--------------------------------------------------------------------------------	
 			Carga de select
 --------------------------------------------------------------------------------*/	
 
if($afiliados){
	$opciones_afiliados = setOption($afiliados, 'id_afiliado', array('apellido', 'nombre'));
}else{
	$opciones_afiliados = '<option></option>';
}
 
/*--------------------------------------------------------------------------------	
 			Contenido
 --------------------------------------------------------------------------------*/	

echo start_content();
?>
				
<form method="post" class="form-horizontal" action="generar_tarjetas" onsubmit="return control_boleta()">
				
	<div class="row divider">
		<?php echo setLabel($this->lang->line('afiliados'));?>
		<div class="col-md-10">
			<select class="form-control" name="afiliados[]" id="afiliados" multiple required/>
				<?php echo $opciones_afiliados;?>
			</select>
		</div>
		<div class="col-md-1">
			<button type="button" class="btn btn-default" id="select-all"><i class="fa fa-arrow-right"></i></button>
			<button type="button" class="btn btn-default divider" id="deselect-all"><i class="fa fa-arrow-left"></i></button>
		</div>
	</div>

	<div class="alert alert-dismissable divider" id="alert" style="display: none;">
		<div id="mensaje_error"></div>
	</div>
    <?php 
    if($this->input->post('ente')){
    	echo '<input type="hidden" name="ente" id="ente" value="'.$this->input->post('ente').'">';
    } 
    ?>			
	<div class="col-md-8 col-md-offset-2 divider text-center">
		<button type="submit" value="upload" class="btn btn-app" id="generar"/>
			<i class="fa fa-barcode"></i> <?php echo $this->lang->line('generar')?>
		</button>
		<img src="<?php echo base_url().'uploads/img/sitio/loading_small.gif'?>" class="image divider hide" id="loading" height= "45px;" style="margin-bottom: 15px;">
	</div>

</form>
<?php 
echo end_content();
?>

<script>

$(function() {
	$('#ente').chosen();
	
	$('#afiliados').multiSelect();
	$('.ms-selectable').unbind("click");
	$('#afiliados').change(function(){
		var count = $("#afiliados :selected").length;
		if(count > <?php echo $config['maximo_afiliados_boletas']?>){
			alert('supero el número de selecciones posibles');
			$('.ms-selectable').hide( "clip" , 1000);
			
		}else{
			$('.ms-selectable').show( "clip" , 1000);
		}
	});
	
	var cantidad_option = $('#afiliados option').length;
	
	if(cantidad_option < <?php echo $config['maximo_afiliados_boletas']?>){
		$('#select-all').click(function(){
			$('#afiliados').multiSelect('select_all');
			$('#afiliados').multiSelect('refresh');
			return false;
		});
		
		$('#deselect-all').click(function(){
			$('#afiliados').multiSelect('deselect_all');
			$('#afiliados').multiSelect('refresh');
			return false;
		});
	}else{
		$('#select-all').addClass('disabled');
		$('#select-all').attr( "title", 'Usted tiene más de <?php echo $config['maximo_afiliados_boletas']?> afiliados, esta función esta deshabilitada');
		$('#deselect-all').addClass('disabled');
		$('#deselect-all').attr( "title", 'Usted tiene más de <?php echo $config['maximo_afiliados_boletas']?> afiliados, esta función esta deshabilitada');
	}
});
</script>