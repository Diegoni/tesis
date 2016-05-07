<?php
$dias_f			= $config['tarjetas_dias'];
$array_fechas	= dates_between(strtotime('-'.$dias_f.' day' , strtotime (date('Y-m-d') )), date('Y-m-d'), 'Y-m-d');

if($afiliados){
	foreach ($afiliados as $row) {
		$afiliado = (array) $row;
	}
}

$totales = array();
if($array_fechas){
	foreach ($array_fechas as $value) {
		$totales[$value] = 0;
	}
}

$cabeceras = array(
	$this->lang->line('agencia'),
	$this->lang->line('terminal'),
	$this->lang->line('nro_transaccion'),
	$this->lang->line('fecha'),
	$this->lang->line('importe'),
);

$html = start_content();

if(isset($mensaje)){
	$html .= setMensaje($mensaje);
}
	$body_acciones = '<form method="post" action="'.base_url().'index.php/tarjetas/abm" class="text-center" >';
	$body_acciones .= '<input type="hidden" name="id_afiliado" value="'.$id_afiliado.'"> ';
	$body_acciones .= table_dlt();
	$body_acciones .= '</form> ';
	
					
$html .= getExportsButtons($cabeceras, $body_acciones);

/*--------------------------------------------------------------------------------	
 			Tabla
 --------------------------------------------------------------------------------*/
 
$html .= start_table($cabeceras);
if($registros){
	foreach ($registros as $row) {
		$registro = array(
			$row->agencia,
			$row->terminal,
			$row->nro_transaccion,
			formatDate($row->fecha_pago),
			formatImporte($row->importe),
		);

		$html .= setTableContent($registro);

		if(isset($totales[$row->fecha_pago])){
			$totales[$row->fecha_pago] = $totales[$row->fecha_pago] + $row->importe;
		}
	}
}
$html .= end_table($cabeceras);

if(!$registros){
	$html .= setMensaje($this->lang->line('empty_tarjetas'), 'info');
}

/*--------------------------------------------------------------------------------	
 			Graficos
 --------------------------------------------------------------------------------*/
 
if($registros){
	$graficos = new Graficos();
	$title = 'Suma pagos los últimos '.$dias_f.' días';
	
	$opcion_barra = array(
		'id' 	=> 'id_barra',
		'title' => $title,
		'type'	=> 'column',
	);
	
	foreach ($totales as $key => $value) {
		$datos_barra['pagos'][formatDatemin($key)] = $value;
	}
	if(isset($datos_barra)){
		$grafico_barra = $graficos->barra($opcion_barra, $datos_barra);	

		$html .= '</section>';
		$html .= setProfile($afiliado);
		$html .= setGraficoDiv('id_barra', 9);
		$html .= '</div>';

		$html .= $grafico_barra;
	}else{
		$html .= '</section>';
		$html .= '</div>';
	}

}else{
	$html .= '</section>';
	$html .= '</div>';
}

$html .= setDatatables(NULL, array(0, 'desc'));

echo $html;
?>