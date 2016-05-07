<?php
$titulos = array(
	array(
		'title'		=> $cant_entes,
		'subtitle'	=> $this->lang->line('entes'),
		'color'		=> 'bg-aqua',
		'icon'		=> 'fa fa-briefcase',
		'link'		=> base_url().'index.php/entes/table',
	),
	array(
		'title'		=> $cant_usuarios,
		'subtitle'	=> $this->lang->line('usuarios'),
		'color'		=> 'bg-green',
		'icon'		=> 'fa fa-user',
		'link'		=> base_url().'index.php/usuarios/table',
	),
	array(
		'title'		=> $this->lang->line('config'),
		'subtitle'	=> $this->lang->line('config'),
		'color'		=> 'bg-yellow',
		'icon'		=> 'fa fa-cogs',
		'link'		=> base_url().'index.php/config/aplicacion',
	),
	array(
		'title'		=> $this->lang->line('config'),
		'subtitle'	=> $this->lang->line('impresion'),
		'color'		=> 'bg-red',
		'icon'		=> 'fa fa-print',
		'link'		=> base_url().'index.php/config/impresion',
	),
);

$html = '<section class="content">';
$html .= '<div class="row">';
$html .= '<section class="col-lg-12">';
			
foreach ($titulos as $valores) {
	$html .= setBoxHome($valores);
}
$html .= '</section">';
$html .= '</div>';


$html .= '<div class="row">';
$html .= '<section class="col-lg-7">';

/*--------------------------------------------------------------------------------	
 			Tabla de log
 --------------------------------------------------------------------------------*/
 
	$html .= '<div class="box box-info">';
		$html .= '<div class="box-header ui-sortable-handle" style="cursor: move;">';
			$html .= '<h3 class="box-title">Last 5 log in</h3>';
		    $html .= '<div class="box-tools pull-right" data-toggle="tooltip" title="" data-original-title="Status">';
			$html .= '</div>';
	 	$html .= '</div>';
	 	$html .= '<div id="table">';
		$cabecera = array(
			$this->lang->line('usuario'),
			$this->lang->line('fecha'),
			$this->lang->line('IP'),
			$this->lang->line('navegador'),
			$this->lang->line('sistema'),
		);
		
		if($logs){
			$html .= start_table($cabecera);
			foreach ($logs as $row) {
				$url = base_url().'index.php/usuarios/logs/'.$row->id_usuario;	
				$contenido = array(
					'<a href="'.$url.'">'.$row->usuario.'</a>',
					formatDateTime($row->last_login),
					$row->ip_login,
					getIcon($row->navegador),
					getIcon($row->sistema)
				);
				
				$html .= setTableContent($contenido);
				
			}
			$html .= end_table();
			$html .= '</div>
			<script>
				$("#table").hide();
				$("#table").show("drop", 1000);
			</script>';
		}
	$html .= '</div>';
	
/*--------------------------------------------------------------------------------	
 			Calendario de feriados
 --------------------------------------------------------------------------------*/

	$html .= '<div class="box box-info">';
		$html .= '<div class="box-header ui-sortable-handle" style="cursor: move;">';
			$html .= '<h3 class="box-title">Feriados</h3>';
		    $html .= '<div class="box-tools pull-right" data-toggle="tooltip" title="" data-original-title="Status">';
			$html .= '</div>';
	 	$html .= '</div>';
		$html .= '<div id="calendar"></div>';
	$html .= '</div>';
	
/*--------------------------------------------------------------------------------	
 			Graficos Lotes
 --------------------------------------------------------------------------------*/

	$html .= setGraficoDiv('id_barra', '0');;
	
$html .= '</section>';

/*--------------------------------------------------------------------------------	
 			Graficos div
 --------------------------------------------------------------------------------*/
 
$html .= '<section class="col-lg-5">';

	$html .= setGraficoDiv('navegadores', '0');;
	$html .= setGraficoDiv('sistemas', '0');	
	$html .= setGraficoDiv('leyendas', '0');

$html .= '</section>';

$html .= '</div>';

/*--------------------------------------------------------------------------------	
 --------------------------------------------------------------------------------
 			Datos Graficos
 --------------------------------------------------------------------------------
 --------------------------------------------------------------------------------*/

$graficos = new Graficos();

$opciones_n	= array(
	'title'		=> 'Navegadores',
	'id'		=> 'navegadores',
	'type'		=> '3d'
);

$opciones_s = array(
	'title'		=> 'Sistemas',
	'id'		=> 'sistemas',
	'type'		=> '3d'
);

$opciones_l = array(
	'title'		=> 'Leyendas',
	'id'		=> 'leyendas',
	'type'		=> 'donut'
);

$opcion_barra = array(
	'id' 	=> 'id_barra',
	'title' => 'Suma lotes generados en los proximos '.$dias_cantidades.' días',
	'type'	=> 'line',
);

//datos navegadores y sistemas
if($usuarios){
	foreach ($usuarios as $row) {
		if($row->navegador != ''){
			if(isset($datos_n[$row->navegador])){
				$datos_n[$row->navegador] = $datos_n[$row->navegador] + 1;
			} else {
				$datos_n[$row->navegador] = 1;
			}
		}
		
		if($row->sistema != ''){
			if(isset($datos_s[$row->sistema])){
				$datos_s[$row->sistema] = $datos_s[$row->sistema] + 1;
			} else {
				$datos_s[$row->sistema] = 1;
			}
		}
	}	
}

//datos leyendas
$datos_l = array();
if($leyendas){
	foreach ($leyendas as $row) {
		if($row->leyenda != ''){
			if(isset($datos_l[$row->leyenda])){
				$datos_l[$row->leyenda] = $datos_l[$row->leyenda] + 1;
			} else {
				$datos_l[$row->leyenda] = 1;
			}
		}
	}
}

//datos lotes
$array_cantidades	= dates_between(date('Y-m-d'), strtotime('+'.$dias_cantidades.' day' , strtotime (date('Y-m-d') )), 'Y-m-d');

if($array_cantidades){
	foreach ($array_cantidades as $value) {
		$total_1[$value] = 0;
		$total_2[$value] = 0;
	}
}

if($lotes){
	foreach ($lotes as $row) {
		if(in_array($row->fecha_venc_1, $array_cantidades) || in_array($row->fecha_venc_2, $array_cantidades)){
			if(isset($total_1[$row->fecha_venc_1])){
				$total_1[$row->fecha_venc_1] = $total_1[$row->fecha_venc_1] + $row->importe_venc_1;
			}
					
			if(isset($total_2[$row->fecha_venc_2])){
				$total_2[$row->fecha_venc_2] = $total_2[$row->fecha_venc_2] + $row->importe_venc_2;
			}
		}
	}
}

	
foreach ($total_1 as $key => $value) {
	$datos_barra['1er'][formatDatemin($key)] = $value;
}
	
foreach ($total_2 as $key => $value) {
	$datos_barra['2do'][formatDatemin($key)] = $value;
}
	
$scripts['nav']	= $graficos->torta($opciones_n, $datos_n);
$scripts['sis']	= $graficos->torta($opciones_s, $datos_s);
$scripts['ley']	= $graficos->torta($opciones_l, $datos_l);
$scripts['bar'] = $graficos->barra($opcion_barra, $datos_barra);

foreach ($scripts as $script) {
	$html .= $script;
}

/*--------------------------------------------------------------------------------	
 --------------------------------------------------------------------------------
 			Datos Calendario
 --------------------------------------------------------------------------------
 --------------------------------------------------------------------------------*/

$calendario = new Calendarios();

$array_feriados = array();
if($feriados){
	foreach ($feriados as $row) {
		$array_feriados[$row->feriado] = $row->fecha;
	}	
}

$script = $calendario->script('calendar', $array_feriados);

$html .= $script;


echo $html;
?>	