<?php
$html = start_content();
$html .= setMensaje(lang('archivo_generado'), 'info');

$html .= '<center><a download href="'.$archivo.'" class="btn btn-app" target="_blank">';
$html .= '<i class="fa fa-download"></i>';
$html .= lang('archivo');
$html .= '</a></center>';
$html .= end_content();

echo $html;
?>