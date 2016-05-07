<?php
$cabeceras = array(
	$this->lang->line('tarjetas'),
	$this->lang->line('afiliados'),
	$this->lang->line('opciones'),
);

$html = start_content();

if(isset($mensaje)){
	$html .= setMensaje($mensaje);
}				

$html .= getExportsButtons($cabeceras);

$html .= start_table($cabeceras);
$html .= end_table($cabeceras);

if(!$registros){
	$link = '<a href="'.base_url().'index.php/'.$subjet.'/alta"><i class="fa fa-arrow-circle-right"></i></a>';
	$html .= setMensaje($this->lang->line('empty_tarjetas').$link, 'info');
}

$html .= end_content();

if($registros){
	if($id_afiliado == 0){
		$html .= setDatatables(NULL, array(0, 'desc'), base_url().'index.php/'.$subjet.'/ajax');
	}else{
		$html .= setDatatables(NULL, array(0, 'desc'), base_url().'index.php/'.$subjet.'/ajax/'.$id_afiliado);
	}	
}else{
	$html .= setDatatables(NULL, array(0, 'desc') );
}

echo $html;
?>