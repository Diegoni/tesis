<?php
$cabeceras = array(
	'<div class="checkbox"><label><input type="checkbox" id="selecctall"/> '.$this->lang->line('nombre').'</label></div>',
	$this->lang->line('extension'),
	$this->lang->line('tipo'),
	$this->lang->line('size'),
	$this->lang->line('date_add'),
	$this->lang->line('dias'),
	$this->lang->line('usuarios'),
	$this->lang->line('entes'),
	$this->lang->line('opciones'),
);


$html = '<form action="eliminar" method="post" class="pull-right">';
$html .= start_content();

if(isset($mensaje) ){
	$html .= setMensaje($mensaje);
}

$html .=
'<div class="col-md-6"></div>
	<div class="col-md-6" style=" padding-bottom: 5px;">';
$html .= table_dlt().'</div>'; 

$warning	= $config_archivos['dias_warning'];
$danger		= $config_archivos['dias_danger'];
$total_size	= 0;

/*--------------------------------------------------------------------------------	
 			Tabla
 --------------------------------------------------------------------------------*/	

$html .= start_table($cabeceras);


if($registros){
	
	if('Linux' == PHP_OS){
		$path = str_replace('application/', '', APPPATH);
	} else {
		$path = str_replace('application\\', '', APPPATH);
		$path = str_replace('\\', '/', $path);
	}
	
	foreach ($registros as $row) {
		if($row->id_origen == 1){
			$path_temp		= str_replace($path, base_url(), $row->path);
			$url			= $path_temp.$row->nombre.$row->extension;
		}else{
			$url			= $row->path.$row->nombre.$row->extension;
		}
		$dias			= dias_transcurridos($row->date_add, date('Y-m-d'));
		$total_size		= $total_size + $row->size;
		if($dias>$danger){
			$class = setSpan($dias, 'danger');
		}else if($dias>$warning){
			$class = setSpan($dias, 'warning');
		}else{
			$class = $dias;
		}
		
		$registro = array(
			'<div class="checkbox"><label><input type="checkbox" class="archivos" name="archivos[]" value="'.$row->id_archivo.'" /> '.$row->nombre.'</label></div>',
			$row->extension,
			$row->tipo,
			formatBites($row->size),
			formatDateTime($row->date_add),
			$class.'</span>',
			'<a title="Ver usuario" href="'.base_url().'index.php/usuarios/abm/'.$row->id_usuario.'">'.$row->usuario.'</a>',
			'<a title="Ver ente" href="'.base_url().'index.php/entes/abm/'.$row->ente.'">'.$row->ente.'</a>',
			'<a download class="btn btn-default" target="_blank" href="'.$url.'"><i class="fa fa-download"></i></a>',
		);
		
		$html .= setTableContent($registro);
	}
}

$html .= end_table($cabeceras);

/*--------------------------------------------------------------------------------	
 			Mensaje de tamaño de archivos en disco
 --------------------------------------------------------------------------------*/	

$mensaje_total = $this->lang->line('total_archivos').formatBites($total_size);
if($total_size > $config_archivos['mensaje_danger']){
	$class = 'danger';
	$mensaje_total .= '. '.$this->lang->line('necesita').' '.$this->lang->line('eliminar_archivos'); 
}else if($total_size > $config_archivos['mensaje_warning']){
	$class = 'warning';
	$mensaje_total .= '. '.$this->lang->line('deberia').' '.$this->lang->line('eliminar_archivos'); 
}else{
	$class = 'info';
}

if($total_size > 0){
	$html .= setMensaje($mensaje_total, $class);	
}

$html .= end_content();
$html .= '</form>';
$html .= setDatatables();

echo $html;