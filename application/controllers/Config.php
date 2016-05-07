<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends My_Controller {

	protected $_subject		= 'config';
	
	function __construct(){
		parent::__construct(
				$subjet		= $this->_subject 
		);
		
		$this->load->model('m_barcore');
		$this->load->model('m_barcore_formatos');
		$this->load->model('m_barcore_tipos');
		$this->load->model('m_impresiones');
		$this->load->model('m_impresiones_campos');
		$this->load->model('m_leyendas');
	} 
		
/*--------------------------------------------------------------------------------	
 			Configuración del sitio: impresión
 --------------------------------------------------------------------------------*/	
  
	public function impresion($mensaje = NULL){
		$db['seccion']		= 'impresion';	
		$db['secciones']	= array('impresion', 'codigo_barra');
			
		if($this->input->post('modificar')){
			$registro = array(
				'impresion'		=> $this->input->post('impresion'),
				'x_hoja'		=> $this->input->post('x_hoja'),
			);
			$this->m_impresiones->update($registro, 1);
			$db['mensajes'] = 'update_ok';
		}
		
		if($this->input->post('barcore')){
			$registro = array(
				'id_tipo'		=> $this->input->post('id_tipo'),
				'id_formato'	=> $this->input->post('id_formato'),
				'canvas_x'		=> $this->input->post('canvas_x'),
				'canvas_y'		=> $this->input->post('canvas_y'),
				'size_x'		=> $this->input->post('size_x'),
				'size_y'		=> $this->input->post('size_y'),
				'width'			=> $this->input->post('width'),
				'height'		=> $this->input->post('height'),
			);
			
			$this->m_barcore->update($registro, 1);
			$db['seccion']	= 'codigo_barra';
			$db['mensajes'] = 'update_ok';
		}
		
		$db['impresiones']		= $this->m_impresiones->getRegistros(1);
		$db['barcore']			= $this->m_barcore->getRegistros();
		$db['barcore_formatos']	= $this->m_barcore_formatos->getRegistros();
		$db['barcore_tipos']	= $this->m_barcore_tipos->getRegistros();
		$db['campos']			= $this->m_impresiones_campos->getRegistros();
		
		$this->armar_vista('impresion', $db);
	}

/*--------------------------------------------------------------------------------	
 			Configuración del sitio: aplicación
 --------------------------------------------------------------------------------*/		
	
	function aplicacion(){
		if($this->input->post('modificar')){
			foreach ($this->input->post('config_key') as $key) {
				if($key != 'mensaje_login'){
					if($this->input->post($key) !== null){
						$registro[$key] = 1;
					}else{
						$registro[$key] = 0;
					}
				}
			}
			
			$registro['mensaje_login']		= $this->input->post('mensaje_login');
			$registro['boletas_cantidad']	= $this->input->post('boletas_cantidad');
			$registro['boletas_dias']		= $this->input->post('boletas_dias');
			$registro['boletas_pagos']		= $this->input->post('boletas_pagos');
			$registro['tarjetas_dias']		= $this->input->post('tarjetas_dias');
			$registro['importe_max']		= $this->input->post('importe_max');
			$registro['input_max']			= $this->input->post('input_max');
			$registro['min_fecha']			= $this->input->post('min_fecha');
			$registro['maximo_afiliados_importacion']	= $this->input->post('maximo_afiliados_importacion');
			$registro['maximo_afiliados_alertas']		= $this->input->post('maximo_afiliados_alertas');
			$registro['maximo_afiliados_boletas']		= $this->input->post('maximo_afiliados_boletas');
			$registro['id_config']			= 1;
			$registro['date_upd']		= date('Y-m-d H:i:s');
			$registro['user_upd']		= $this->_session_data['id_usuario'];
			
			$this->m_config->update($registro, 1);
			$db['mensaje'] = 'update_ok';
		}
		
		$db['registro']	= $this->_config;
		$db['leyendas']	= $this->m_leyendas->getRegistros();
		
		$this->armar_vista('config', $db);
	}

/*--------------------------------------------------------------------------------	
 			Configuración del sitio: informacion de php
 --------------------------------------------------------------------------------*/		
	
	function info(){
		echo phpinfo();
	}	
}
