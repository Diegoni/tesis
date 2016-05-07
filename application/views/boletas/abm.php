<?php
/*--------------------------------------------------------------------------------	
 			Carga inicial de valores
 --------------------------------------------------------------------------------*/	
 	
if($registro){
	foreach ($registro as $row) {
		if($row->pago == 0 && date('Y-m-d') > $row->fecha_venc_1){
			$vencimiento_1 = formatDate($row->fecha_venc_1).dias_transcurridos($row->fecha_venc_1, date('Y-m-d'), TRUE);
		}else{
			$vencimiento_1 = formatDate($row->fecha_venc_1);
		}
		
		if($row->pago == 0 && date('Y-m-d') > $row->fecha_venc_2){
			$vencimiento_2 = formatDate($row->fecha_venc_2).dias_transcurridos($row->fecha_venc_1, date('Y-m-d'), TRUE);
		}else{
			$vencimiento_2 = formatDate($row->fecha_venc_2);
		}
		
		$nombre = '<a href="'.base_url().'index.php/Afiliados/abm/'.$row->id_afiliado.'">'.$row->nombre.'</a>';
		$lote = $row->nombre_lote.' <a href="'.base_url().'index.php/boletas/generar_impresion/'.$row->id_lote.'" class="btn btn-default btn-sm"><i class="fa fa-print"></i> '.$this->lang->line('imprimir').'</a>';

		
		$registro_values = array(
			'boletas'		=> $row->id_boleta,
			'nombre'		=> $nombre,
			'codigo'		=> $row->cod_afiliado,
			'vencimiento_1'	=> $vencimiento_1,
			'importe_1'		=> formatImporte($row->importe_venc_1),
			'vencimiento_2'	=> $vencimiento_2,
			'importe_2'		=> formatImporte($row->importe_venc_2),
			'date_add'		=> formatDatetime($row->date_add),
			'usuario'		=> $row->usuario,
			'lote'			=> $lote,
		);
	}
}

if($pago){
	$class = 'default';

	foreach ($pago as $row) {
		$pago_values['agencia']			= $row->agencia;
		$pago_values['terminal']		= $row->terminal;
		$pago_values['nro_transaccion'] = $row->nro_transaccion;
		$pago_values['fechapago']		= formatDate($row->fechapago);
		$pago_values['importe']			= formatImporte($row->importe);
	}
}else{
	$class = 'warning';
}


$html = '<section class="content">';
$html .= '<div class="row">';

/*--------------------------------------------------------------------------------	
 			Box de boleta
 --------------------------------------------------------------------------------*/	
 
if($registro){
	$cabeceras = array(
		$this->lang->line('campo'),
		$this->lang->line('valor')
	);
						
	$body = start_table($cabeceras);
	foreach ($registro_values as $key => $value) {
		$registro = array(
			$this->lang->line($key),
			$value,
		);	
							
		$body .= setTableContent($registro);
	}
	$body .= end_table();
}else{
	$body = setMensaje(lang('no_registro'), 'error');;
}	
		
$html .= setBoxSolid($this->lang->line('boletas'), $body);

/*--------------------------------------------------------------------------------	
 			Box de pago
 --------------------------------------------------------------------------------*/	
		
$header = array(
	'class' => $class,
	'title'	=> $this->lang->line('pago'),
); 
		
if($pago){
	$cabeceras = array(
		$this->lang->line('campo'),
		$this->lang->line('valor')
	);
			
	$body_pago = start_table($cabeceras);
	foreach ($pago_values as $key => $value) {
		$registro = array(
			$this->lang->line($key),
			$value,
		);	
				
		$body_pago .= setTableContent($registro);
	}
	$body_pago .= end_table();
	
	$html .= setBoxSolid($header, $body_pago);
} else {
	$body_pago = $this->lang->line('no_pago');
	$html .= setBoxSolid($header, $body_pago);
	
	$body_acciones = '<form method="post" action="'.base_url().'index.php/boletas/abm" >';
	$body_acciones .= '<input type="hidden" name="id_boleta" value="'.$id_boleta.'">';
	$body_acciones .= button_dlt();
	$body_acciones .= '</form>';
	$html .= setBoxSolid(lang('acciones'), $body_acciones);
}
		
$html .= '</div>';
$html .= '</section>';

echo $html;
