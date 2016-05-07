<?php 
$html = start_content();

if(isset($mensaje)){ 
	if(strpos($mensaje, 'No ha seleccionado')){
		$tipo = 'ok';
	} else {
		$tipo = 'error';
	}
	
	$html .= setMensaje($mensaje, $tipo);
}

$id_modal = 'help';

$html .= form_open_multipart($subjet.'/do_upload');

$html .= '<div class="row">';
$html .= setlabel($this->lang->line('archivo'), 2);
$html .= '<div class="col-md-8">';
$html .= '<div class="form-group">';
$html .= '<input type="file" class="form-control" name="userfile" />';
$html .= '</div>';
$html .= '</div>';
$html .= '<div class="col-md-2">';
$html .= '</div>';
$html .= '</div>';

$html .= '<div class="row">';
$html .= '<div class="col-md-8 col-md-offset-2 text-center">';
$html .= button_upl();
$html .= '</div>';
$html .= '</div>';

$html .= '</form>';

$html .= end_content();
$html .= get_modal($id_modal, $mensaje);

echo $html;
?>