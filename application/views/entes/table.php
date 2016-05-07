<?php
$cabeceras = array(
	$this->lang->line('nombre'),
	$this->lang->line('codigo'),
	$this->lang->line('cuit'),
	$this->lang->line('telefono'),
	array(lang('boletas')	=> '<i class="fa fa-file-text-o"></i>'),
	array(lang('tarjetas')	=> '<i class="fa fa-credit-card"></i>'),
	$this->lang->line('opciones'),
);

$html = start_content();

if(isset($mensaje)){
	$html .= setMensaje($mensaje);
}

if($permisos['agregar'] == 1){
	$html .= getExportsButtons($cabeceras, table_add($subjet));
}else{
	$html .= getExportsButtons($cabeceras);
}

$html .= start_table($cabeceras);
$html .= end_table($cabeceras);

$html .= end_content();

if($registros){
	$html .= setDatatables(NULL, 0, base_url().'index.php/entes/ajax');
}else{
	$html .= setDatatables();
}

echo $html;
?>
