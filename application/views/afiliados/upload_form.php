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
$html .= btn_modal($id_modal);
$html .= '</div>';
$html .= '</div>';

$html .= '<div class="row">';
$html .= '<div class="col-md-8 col-md-offset-2 text-center">';
$html .= button_upl();
$html .= '</div>';
$html .= '</div>';

$html .= '</form>';

$mensaje = 
"<p>Se debe seleccionar el archivo 'SRPAfiliados.xls' generado por el sistema anterior.</p>
<p>Para generarlo</p>
<ul>
	<li>Seleccionar 'Operaciones->Generar Listados'</li>
		<img src='".base_url()."uploads/img/ayuda/paso_1.png' class='img-responsive img-thumbnail'>
	<hr>
	<li>Seleccionar 'Listdo de Afiliados'</li>
		<img src='".base_url()."uploads/img/ayuda/paso_2.png' class='img-responsive img-thumbnail'>
	<hr>
	<li>Generar archivo</li>
</ul>";

$html .= end_content();
$html .= get_modal($id_modal, $mensaje);

echo $html;
?>