<?php
$cabeceras = array(
	$this->lang->line('fecha'),
	$this->lang->line('ip'),
	$this->lang->line('acciones'),
	$this->lang->line('tabla'),
	$this->lang->line('registro'),
);
$html = start_content();
$html .= getExportsButtons($cabeceras);

$html .= start_table($cabeceras);

if($registros){
	foreach ($registros as $row) {
		$registro = array(
			$row->fecha,
			$row->ip_login,
			getColorAction($row->action),
			getIcon($row->tabla),
			getIcon($row->registro),
		);
		
		$html .= setTableContent($registro);
	}
}
			
$html .=  end_table($cabeceras);			
			
$html .=  end_content();
$html .=  setDatatables();

echo $html;
?>
