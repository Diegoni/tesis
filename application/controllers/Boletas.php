<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Boletas extends My_Controller {

	protected $_subject		= 'boletas';
	
	function __construct(){
		parent::__construct(
				$subjet		= $this->_subject 
		);
		
		$this->load->model('m_afiliados');
		$this->load->model('m_barcore');
		$this->load->model('m_boletas');
		$this->load->model('m_entes');
		$this->load->model('m_impresiones');
		$this->load->model('m_impresiones_campos');
		$this->load->model('m_feriados');
		$this->load->model('m_localidades');
		$this->load->model('m_lotes');
		$this->load->model('m_pagos_boletas');
		$this->load->model('m_provincias');

	} 
		
/*--------------------------------------------------------------------------------	
 			Alta masiva de boletas: Formulario
 --------------------------------------------------------------------------------*/

	public function alta(){
		$db['feriados']		= $this->m_feriados->getRegistros();
		$db['lotes_ant']	= $this->m_lotes->getRegistros($this->_session_data['id_ente'], 'id_ente');
		$db['afiliados']	= $this->m_afiliados->getAfiliados($this->_session_data['id_ente'], $this->_session_data['id_usuario']);
			
		if($this->input->post('lote_base')){
			$db['datos_lote']		= $this->m_lotes->getRegistros($this->input->post('lote_base'));
			$db['afiliados_lote']	= $this->m_boletas->getLote($this->input->post('lote_base'), $this->_session_data['id_ente']);
		}
			
		$this->armar_vista('alta', $db);
	}
	
/*--------------------------------------------------------------------------------	
 			Alta masiva de boletas: Generación
 --------------------------------------------------------------------------------*/	
	
	public function generar_boletas(){
		$array_fecha1 = explode("/", $this->input->post('primera_fecha'));
		$array_fecha2 = explode("/", $this->input->post('segunda_fecha'));

		$registro = array(
			'fecha_venc_1'		=> $array_fecha1[2].'-'.$array_fecha1[1].'-'.$array_fecha1[0],
			'importe_venc_1'	=> $this->input->post('primer_importe'),
			'fecha_venc_2'		=> $array_fecha2[2].'-'.$array_fecha2[1].'-'.$array_fecha2[0],
			'importe_venc_2'	=> $this->input->post('segundo_importe'),
			'id_ente'			=> $this->_session_data['id_ente'],
			'nombre'			=> $this->input->post('nombre'),
			'nro_cuota'			=> $this->input->post('nro_cuota'),
		);
			
		$registro['id_lote'] = $this->m_lotes->insert($registro);
		unset($registro['nombre']);
		
		foreach ($this->input->post('afiliados') as $id_afiliado) {
			if($id_afiliado){
				$registro['id_afiliado'] = $id_afiliado;
				$id_control = $this->m_boletas->control_generadas($registro);
					
				if($id_control == 0){
					$this->m_boletas->insertBoleta($registro);
				}else{
					$url = '<p><a href="'.base_url().'index.php/boletas/abm/'.$id_control.'" >'.$this->lang->line('boleta_existente').'</a></p>';
					$this->alerta($url);
				}
			}
		};
			
		redirect('/'.$this->_subject.'/generar_impresion/'.$registro['id_lote'], 'refresh');
	}

/*--------------------------------------------------------------------------------	
 			Alta masiva de boletas: Impresión
 --------------------------------------------------------------------------------*/
	
	public function generar_impresion($id_lote = NULL, $id_boleta = NULL){
		if($this->input->post('id_lote')){
			foreach ($this->input->post($id_lote) as $value) {
				redirect('/'.$this->_subject.'/generar_impresion/'.$value, 'refresh');
			}
		}
		
		$db['lotes_ant']	= $this->m_lotes->getRegistros($this->_session_data['id_ente'], 'id_ente');
		
		if($id_lote != NULL){
			if($id_boleta != NULL){
				$db['boletas']		= $this->m_boletas->getBoleta($id_boleta);
			}else{
				$db['boletas']		= $this->m_boletas->getLote($id_lote, $this->_session_data['id_ente']);
			}
				
			$db['impresiones']	= $this->m_impresiones->getRegistros(1);
			$db['impresiones_campos'] = $this->m_impresiones_campos->getRegistros();
			$db['lote_select']	= $id_lote;
		}
			
		$this->armar_vista('impresion', $db);
	}
	
/*--------------------------------------------------------------------------------	
 			Administración de boletas: tabla
 --------------------------------------------------------------------------------*/	
	
	function table($id_afiliado = NULL){
		$this->load->library('Graficos');
		if($id_afiliado === NULL){
			$db['id_afiliado']	= 0;	
			$db['registros']	= $this->m_boletas->getBoletas($this->_session_data['id_ente']);
			$db['pagos']		= $this->m_pagos_boletas->getPagos($this->_config['boletas_pagos']*-1);
		}else if ($id_afiliado == 0){
			$db['mensaje']		= 'update_ok';
			$db['id_afiliado']	= 0;
			$db['registros']	= $this->m_boletas->getBoletas($this->_session_data['id_ente']);
			$db['pagos']		= $this->m_pagos_boletas->getPagos($this->_config['boletas_pagos']*-1);
		}else{
			$db['id_afiliado']	= $id_afiliado;
			$db['registros']	= $this->m_boletas->getBoletas($this->_session_data['id_ente'], $id_afiliado);
			$db['pagos']		= $this->m_pagos_boletas->getPagos($this->_config['boletas_pagos']*-1, $id_afiliado);
			$db['afiliados']	= $this->m_afiliados->getRegistros($id_afiliado);
		}
			
		$this->armar_vista('table', $db);
	}
	
/*--------------------------------------------------------------------------------	
 			Administración de boletas: ajax para armar tabla
 --------------------------------------------------------------------------------*/	
 	
	public function ajax($id_afiliado = NULL){
		if($id_afiliado == NULL){
			$registros	= $this->m_boletas->getBoletas($this->_session_data['id_ente']);
		}else{
			$registros	= $this->m_boletas->getBoletas($this->_session_data['id_ente'], $id_afiliado);
		}
		$json = "";
		if($registros){
			$btn_class 		= "'btn btn-default'";
			$btn_classxs	= "'btn btn-default btn-xs'";
			$icon_class		= "'fa fa-pencil-square-o'";
			$icon_print		= "'fa fa-print'";
			$icon_bolafi	= "'fa fa-file-text-o'";
			$title_modificar= "'Ver'";
			$title_imprimir	= "'Imprimir'";
			$title_bolafi	= "'Ver boletas afiliado'";
			$title_afi 		= "'Ver afiliado'";
			$url_bol_i 		= "'".base_url()."index.php/boletas/abm/";
			$url_afi_i 		= "'".base_url()."index.php/afiliados/abm/";
			$url_pri_i 		= "'".base_url()."index.php/Boletas/generar_impresion/";
			$url_bolafi_i 	= "'".base_url()."index.php/Boletas/table/";
			

			foreach ($registros as $row) {
				$url_bol_f = $row->id_boleta."'";
				$url_afi_f = $row->id_afiliado."'";
				$url_pri_f = $row->id_lote."/".$row->id_boleta."'";
				
				if(date('Y-m-d') > $row->fecha_venc_1 && $row->pago == 0){
					$registro['fecha_venc_1']	= setSpan(formatDate($row->fecha_venc_1), 'default');
					$registro['importe_venc_1']	= setSpan(formatImporte($row->importe_venc_1), 'default');
				}else{
					$registro['fecha_venc_1']	= formatDate($row->fecha_venc_1);
					$registro['importe_venc_1']	= formatImporte($row->importe_venc_1);
				}
								
				if(date('Y-m-d') > $row->fecha_venc_2 && $row->pago == 0){
					$registro['fecha_venc_2']	= setSpan(formatDate($row->fecha_venc_2), 'default');
					$registro['importe_venc_2']	= setSpan(formatImporte($row->importe_venc_2), 'default');
				}else{
					$registro['fecha_venc_2']	= formatDate($row->fecha_venc_2);
					$registro['importe_venc_2'] = formatImporte($row->importe_venc_2);
				}
				$registro['nombre'] = '<a title='.$title_afi.' href='.$url_afi_i.$url_afi_f.'>'.$row->nombre.'</a>';
				if($id_afiliado == NULL){
					$registro['nombre'] .= ' <a class='.$btn_classxs.' title='.$title_bolafi.' href='.$url_bolafi_i.$url_afi_f.'><i class='.$icon_bolafi.'></i></a>';
				}		
				$registro['codigo'] = $row->codigo_afiliado;
				if($row->eliminado == 1){
					$registro['estado'] = estadoPago(-1);
					$registro['buttons'] = "";	
				}else{
					$registro['estado'] = estadoPago($row->pago);
					$registro['buttons'] = '<a class='.$btn_class.' title='.$title_modificar.' href='.$url_bol_i.$url_bol_f.'><i class='.$icon_class.'></i></a>';
					$registro['buttons'] .= ' <a class='.$btn_class.' title='.$title_imprimir.' href='.$url_pri_i.$url_pri_f.'><i class='.$icon_print.'></i></a>';	
				}
				
		 		$json .= setJsonContent($registro);
			}
			
			$json = substr($json, 0, -2);
		}
		echo '{ "data": ['.$json.' ]  }';
	}
	
/*--------------------------------------------------------------------------------	
 			Administración de boletas: registro
 --------------------------------------------------------------------------------*/	
	
	function abm($id_boleta = NULL){
		if($this->input->post('id_boleta')){
			$this->m_boletas->delete($this->input->post('id_boleta'));
			redirect('boletas/table/0', 'refresh');
		}else{
			$db['registro']	= $this->m_boletas->getBoleta($id_boleta);
			$db['pago']		= $this->m_pagos_boletas->getRegistros($id_boleta, 'id_boleta');
			$db['id_boleta']= $id_boleta;
			
			$this->armar_vista('abm', $db);	
		}
	}
	
/*--------------------------------------------------------------------------------	
 			Administración de boletas: generación de PDF, no se usa
 --------------------------------------------------------------------------------*/	
	
	function pdf($id_lote = NULL, $id_boleta = NULL){
		$this->load->library('PDFF');
		
		if($id_boleta != NULL){
			$db['boletas']		= $this->m_boletas->getBoletas($id_boleta);
		}else{
			$db['boletas']		= $this->m_boletas->getLote($id_lote, $this->_session_data['id_ente']);
		}
		
		$db['impresiones_campos'] = $this->m_impresiones_campos->getRegistros();
		$db['impresiones']		= $this->m_entes->getRegistros($this->_session_data['id_ente']);
		
		$this->load->view( $this->_subject.'/pdf', $db);
	}
	
/*--------------------------------------------------------------------------------	
 			Administración de boletas: generación de la imagen
 --------------------------------------------------------------------------------*/	
	
	function generacion_codigo($code){
		$barcore		= $this->m_barcore->getRegistros();
		foreach ($barcore as $row) {
			$config = (array) $row;
		}
		
		$this->load->library('Barcores');
		$fontSize = 10;   					// GD1 in px ; GD2 in point
		$marge    = 10;   					// between barcode and hri in pixel
		$x        = $config['canvas_x'];	// barcode center
		$y        = $config['canvas_y'];	// barcode center
		$height   = $config['height'] ;		// barcode height in 1D ; module size in 2D
		$width    = $config['width'] ;		// barcode height in 1D ; not use in 2D
		$angle    = 0;   					// rotation in degrees : nb : non horizontable barcode might not be usable because of pixelisation
  		$type     = $config['tipo'] ;
	
		// configuracion de la imagen
		
		$im     = imagecreatetruecolor($config['size_x'], $config['size_y']);
		$black  = ImageColorAllocate($im,0x00,0x00,0x00);
		$white  = ImageColorAllocate($im,0xff,0xff,0xff);
		$red    = ImageColorAllocate($im,0xff,0x00,0x00);
		$blue   = ImageColorAllocate($im,0x00,0x00,0xff);
		imagefilledrectangle($im, 0, 0, $config['size_x'], $config['size_y'], $white);
  
		// configuracion del codigo de barra
		$data = Barcode::gd(
			$im, 
		  	$black, 
			$x, 
			$y, 
			$angle, 
			$type, 
			array('code'=>$code), 
			$width, 
			$height
		);

		// generacion de la imagen
		
  		header('Content-type: image/gif');
  		imagepng($im);
  		imagedestroy($im);
	}
}