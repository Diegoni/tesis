<?php
/*--------------------------------------------------------------------------------	
 			Carga de datos iniciales
 --------------------------------------------------------------------------------*/	
 
$dias_f	= $config['boletas_dias'];
$dias_c	= $config['boletas_cantidad'];
$dias_p	= $config['boletas_pagos'];

$array_fechas		= dates_between(date('Y-m-d'), strtotime('+'.$dias_f.' day' , strtotime (date('Y-m-d') )), 'Y-m-d');
$array_cantidades	= dates_between(date('Y-m-1'), strtotime('+'.$dias_c.' day' , strtotime (date('Y-m-d') )), 'Y-m-d');
$array_fechas_pagos	= dates_between(strtotime('-'.$dias_p.' day' , strtotime (date('Y-m-d') )), date('Y-m-d'), 'Y-m-d');

if(isset($afiliados)){
	foreach ($afiliados as $row) {
		$afiliado = (array) $row;
	}
}

if($array_fechas){
	foreach ($array_fechas as $value) {
		$total_1[$value] = 0;
		$total_2[$value] = 0;
	}
	
	if(isset($pagos)){
		foreach ($array_fechas_pagos as $value) {
				$totales_pagos[$value] = 0;
		}
	}
}


$cabeceras = array(
	$this->lang->line('vencimiento_1'),
	$this->lang->line('importe'),
	$this->lang->line('vencimiento_2'),
	$this->lang->line('importe'),
	$this->lang->line('nombre'),
	$this->lang->line('codigo'),
	$this->lang->line('pago'),
	$this->lang->line('opciones'),
);

/*--------------------------------------------------------------------------------	
 			Contenido : tabla
 --------------------------------------------------------------------------------*/	

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

if($registros){
	$pagadas	= 0;
	$pendientes = 0;
	$eliminadas	= 0;
		
	foreach ($registros as $row) {
		if(in_array($row->fecha_venc_1, $array_cantidades) || in_array($row->fecha_venc_2, $array_cantidades)){
			if($row->eliminado == 1){
				$eliminadas = $eliminadas + 1;
			}else{		
				if($row->pago == 0){
					$pendientes = $pendientes + 1;
					if(isset($total_1[$row->fecha_venc_1])){
						$total_1[$row->fecha_venc_1] = $total_1[$row->fecha_venc_1] + $row->importe_venc_1;
					}
							
					if(isset($total_2[$row->fecha_venc_2])){
						$total_2[$row->fecha_venc_2] = $total_2[$row->fecha_venc_2] + $row->importe_venc_2;
					}
				}else{
					$pagadas = $pagadas + 1;
				}
			}
		}	
	}
}

if(isset($pagos) && $pagos){
	foreach ($pagos as $row) {
		if(isset($totales_pagos[$row->fechapago])){
			$totales_pagos[$row->fechapago] = $totales_pagos[$row->fechapago] + $row->importe;
		}
	}
}

$html .= end_table($cabeceras);

if(!$registros){
	$link = '<a href="'.base_url().'index.php/boletas/alta"><i class="fa fa-arrow-circle-right"></i></a>';
	$html .= setMensaje($this->lang->line('empty_boletas').$link, 'info');
}

/*--------------------------------------------------------------------------------	
 			Contenido: graficos
 --------------------------------------------------------------------------------*/	

if(isset($pendientes)){
	$graficos = new Graficos();
	
	/* 
		GRAFICO DE TORTA
	*/
	
	$title = 'Cantidad de boletas los próximos '.$dias_c.' días';
	
	$opcion_torta = array(
		'id' 	=> 'id_torta', 
		'title' => $title,
	);
	$datos_torta = array(
		'Pendientes'	=> array(
			'value'	=> $pendientes,
			'color' => 'f39c12' 
		),
		'Pagadas' 		=> array(
			'value'	=> $pagadas,
			'color' => '00a65a' 
		),
		'Eliminadas'	=> array(
			'value'	=> $eliminadas,
			'color' => 'dd4b39' 
		),
	);
	
	$grafico_torta  = $graficos->torta($opcion_torta, $datos_torta);
	
	/*
		GRAFICO DE BARRA
	*/
	
	$title = 'Suma vencimientos los próximos '.$dias_f.' días';
	
	$opcion_barra = array(
		'id' 	=> 'id_barra',
		'title' => $title,
		'type'	=> 'line',
	);
	
	foreach ($total_1 as $key => $value) {
		$datos_barra['1er'][formatDatemin($key)] = $value;
	}
	
	foreach ($total_2 as $key => $value) {
		$datos_barra['2do'][formatDatemin($key)] = $value;
	}
	
	$grafico_barra = $graficos->barra($opcion_barra, $datos_barra);
	// Preparamos los div donde van a ir los graficos
	
	$html .= '</section>';
	$html .= setGraficoDiv('id_torta', 6);
	$html .= setGraficoDiv('id_barra', 6);
	
	if(isset($pagos) && $pagos){
		$title = 'Suma pagos los últimos '.$dias_p.' días';
		
		$opcion_barra = array(
			'id' 	=> 'id_pago',
			'title' => $title,
			'type'	=> 'column',
		);
		
		foreach ($totales_pagos as $key => $value) {
			$datos_pagos['pagos'][formatDatemin($key)] = $value;
		}
		if(isset($datos_barra)){
			$grafico_pago = $graficos->barra($opcion_barra, $datos_pagos);	
			
			if(isset($afiliado)){
				$html .= setProfile($afiliado);
				$html .= setGraficoDiv('id_pago', 9);
			}else{
				$html .= setGraficoDiv('id_pago', 12);
			}
			$html .= $grafico_pago;
		}
	}
	
	$html .= '</div>';
	
	// Las dos funciones me devuelven el javascript necesario para armar el grafico.
	$html .= $grafico_torta;
	$html .= $grafico_barra;
}else{
	$html .= '</section>';
	$html .= '</div>';
}


if($registros){
	if($id_afiliado == 0){
		$html .= setDatatables(NULL, array(0, 'desc'), base_url().'index.php/boletas/ajax');
	}else{
		$html .= setDatatables(NULL, array(0, 'desc'), base_url().'index.php/boletas/ajax/'.$id_afiliado);
	}
	
}else{
	$html .= setDatatables(NULL, array(0, 'desc') );
}

echo $html;
?>