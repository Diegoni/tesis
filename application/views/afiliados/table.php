<?php
$cabeceras = array(
	$this->lang->line('nombre'),
	$this->lang->line('apellido'),
	$this->lang->line('codigo'),
	$this->lang->line('opciones'),
);

$html = start_content();

if(isset($mensaje) && $mensaje != ''){
	$html .= setMensaje($mensaje);
}
					
if($permisos['agregar'] == 1){
	$html .= getExportsButtons($cabeceras, table_add($subjet));
}else{
	$html .= getExportsButtons($cabeceras);
}

$html .= start_table($cabeceras);
$html .= end_table($cabeceras);

if(!$registros){
	$link = '<a href="'.base_url().'index.php/afiliados/upload"><i class="fa fa-arrow-circle-right"></i></a>';
	$html .= setMensaje($this->lang->line('empty_afiliados').$link, 'info');
}

$html .= end_content();

if($registros){
	$html .= setDatatables(NULL, 0, base_url().'index.php/afiliados/ajax');
}else{
	$html .= setDatatables();
}

echo $html;
?>