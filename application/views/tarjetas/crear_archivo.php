<?php
echo '<script src="'.base_url().'librerias/multiselect/js/jquery.multi-select.js"></script>';
echo '<link href="'.base_url().'librerias/multiselect/css/multi-select.css" rel="stylesheet">';

$tarjetas_array = array();

/*--------------------------------------------------------------------------------	
 			Carga de select
 --------------------------------------------------------------------------------*/	
 
if($registros){
	$opciones_tarjetas = setOption($registros, 'codigo_barra', array('apellido', 'nombre'));
}else{
	$opciones_tarjetas = '<option></option>';
}
 
/*--------------------------------------------------------------------------------	
 			Contenido
 --------------------------------------------------------------------------------*/	

echo start_content();
?>
				
<form method="post" class="form-horizontal" action="generar_tarjetas" onsubmit="return control_boleta()">
				
	<div class="row divider">
		<?php echo setLabel($this->lang->line('tarjetas'));?>
		<div class="col-md-10">
			<select class="form-control" name="tarjetas[]" id="tarjetas" multiple required/>
				<?php echo $opciones_tarjetas;?>
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
	
	$('#tarjetas').multiSelect();
	$('.ms-selectable').unbind("click");
	$('#tarjetas').change(function(){
		var count = $("#tarjetas :selected").length;
		if(count > <?php echo $config['maximo_afiliados_boletas']?>){
			alert('supero el número de selecciones posibles');
			$('.ms-selectable').hide( "clip" , 1000);
			
		}else{
			$('.ms-selectable').show( "clip" , 1000);
		}
	});
	
	var cantidad_option = $('#tarjetas option').length;
	
	if(cantidad_option < <?php echo $config['maximo_afiliados_boletas']?>){
		$('#select-all').click(function(){
			$('#tarjetas').multiSelect('select_all');
			$('#tarjetas').multiSelect('refresh');
			return false;
		});
		
		$('#deselect-all').click(function(){
			$('#tarjetas').multiSelect('deselect_all');
			$('#tarjetas').multiSelect('refresh');
			return false;
		});
	}else{
		$('#select-all').addClass('disabled');
		$('#select-all').attr( "title", 'Usted tiene más de <?php echo $config['maximo_afiliados_boletas']?> tarjetas, esta función esta deshabilitada');
		$('#deselect-all').addClass('disabled');
		$('#deselect-all').attr( "title", 'Usted tiene más de <?php echo $config['maximo_afiliados_boletas']?> tarjetas, esta función esta deshabilitada');
	}
});
</script>