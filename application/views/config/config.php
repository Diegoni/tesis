<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$html = css_libreria('plugins/bootstrap-switch-master/dist/css/bootstrap3/bootstrap-switch.css');
$html .= js_libreria('plugins/bootstrap-switch-master/dist/js/bootstrap-switch.js');

$html .= start_content();

if(isset($mensaje)){
	$html .= setMensaje($mensaje);
}

$textArea = 
'<div class="form-group">'.setLabel($this->lang->line('mensaje'), 2).'
	<div class="col-sm-10">
		<textarea class="form-control" id="mensaje_login" name="mensaje_login">'.$registro['mensaje_login'].'</textarea>
	</div>
</div>';

/*--------------------------------------------------------------------------------	
 			Armado del contenido del formulario
 --------------------------------------------------------------------------------*/	

$contenido = array(
	'log_in' => array(
		$textArea,
		setCheckbox('alerta_login_no_entes', $registro),
		setCheckbox('alerta_login_user_dlt', $registro),
	),
	'afiliados' => array(
		setCheckbox('alerta_afiliado_incompleto', 		$registro),
	    setCheckbox('alerta_afiliado_existente', 		$registro),
	    setCheckbox('delete_afiliado_boleta', 			$registro),
	    setConfigInput('maximo_afiliados_importacion',	$registro),
	    setConfigInput('maximo_afiliados_alertas',		$registro),
	    setConfigInput('maximo_afiliados_boletas',		$registro),
	),
	'entes' => array(
		setCheckbox('delete_ente_boleta',		$registro),
	),
	'boletas' => array(
		setConfigInput('boletas_cantidad',	$registro),
		setConfigInput('boletas_dias',		$registro),
		setConfigInput('boletas_pagos',		$registro),
		setCheckbox('usar_min_fecha',		$registro),
		setConfigInput('usar_min_fecha',	$registro),
	),
	'tarjetas' => array(
		setConfigInput('tarjetas_dias',	$registro),
	),
	'pagos_boletas' => array(
		setCheckbox('comparar_decimales',		$registro),
	   	setCheckbox('alerta_pago_iguales',		$registro),
		setCheckbox('alerta_pago_no_ingresado',	$registro),
		setCheckbox('alerta_codigo_no_existe',	$registro),
	),
	'pagos_tarjetas' => array(
		setCheckbox('alerta_pago_no_ingresado_tarjetas',	$registro),
	   	setCheckbox('alerta_codigo_no_existe_tarjetas',		$registro),
	),
	'config' => array(
		setCheckbox('alertas',			$registro),
	   	setConfigInput('input_max',		$registro),
	   	setConfigInput('importe_max',	$registro),
	),
);

$html .= '<form method="post" class="form-horizontal" action="'.base_url().'index.php/config/aplicacion/">';

/*--------------------------------------------------------------------------------	
 			Cabecera del panel
 --------------------------------------------------------------------------------*/
 	
$html .= '<ul class="nav nav-tabs">';
$i = 0;
foreach ($contenido as $key => $value) {
	if($i == 0){
		$html .= '<li class="active"><a data-toggle="tab" href="#'.$key.'">'.lang($key).'</a></li>';
	}else{
		$html .= '<li><a data-toggle="tab" href="#'.$key.'">'.lang($key).'</a></li>';
	}
	$i = $i + 1;
}

$html .= '</ul>';
	
foreach ($registro as $key => $value) {
	$html .= '<input type="hidden" name="config_key[]" value="'.$key.'">';
}

/*--------------------------------------------------------------------------------	
 			Contenido del panel
 --------------------------------------------------------------------------------*/	

$html .= '<div class="tab-content">';

$i = 0;
foreach ($contenido as $key => $value) {
	if($i == 0){
		$html .= '<div id="'.$key.'" class="tab-pane fade in active divider">';
	}else{
		$html .= '<div id="'.$key.'" class="tab-pane fade divider">';
	}
			
	foreach ($value as $inputs) {
		$html .= $inputs;
	}
	$html .= '</div>';
	$i = $i + 1;
}

/*--------------------------------------------------------------------------------	
 			Button de actualizar
 --------------------------------------------------------------------------------*/	
		
$html .= '<div class="box-footer">';
$html .= button_upd(NULL, 12);	
$html .= '</div>';	
$html .= '</form>';					

$html .= end_content();


echo $html;
?>

<script>
$(function () {
	CKEDITOR.replace('mensaje_login');
});

$('.checkbox').each(function(){ 
	if(this.value == 1){
		this.checked = true;
	}
});

$(".checkbox").bootstrapSwitch();
</script>