<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pagos_tarjetas extends My_Controller {

	protected $_subject		= 'pagos_tarjetas';
	
	function __construct(){
		parent::__construct(
				$subjet		= $this->_subject 
		);
		
		$this->load->model('m_archivos');
		$this->load->model('m_config_archivos');
		$this->load->model('m_tarjetas');
		$this->load->model('m_pagos_tarjetas');
		$this->load->helper(array('form', 'url'));
	} 
		
/*--------------------------------------------------------------------------------	
 			Administración de Pagos: formulario
 --------------------------------------------------------------------------------*/

	public function upload($mensaje = NULL){
		if($mensaje != NULL){
			$db['mensaje']	= $mensaje;
			$this->armar_vista('upload', $db);
		} else {
			$this->armar_vista('upload');
		}
	}
	
/*--------------------------------------------------------------------------------	
 			Administración de Pagos: carga del archivo
 --------------------------------------------------------------------------------*/	
	
	public function do_upload(){
		$config_archivos 			= $this->m_config_archivos->getConfig();
		
		$config['upload_path']		= $this->_upload.$this->_subject.'/' ; // Configuramos algunos parametros 
		$config['allowed_types']	= $config_archivos['pagos_type'];
		$config['max_size']			= $config_archivos['pagos_size'];

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload()){ // Controlamos upload, si no se realizo mostramos error
			$mensaje = $this->upload->display_errors();
			$this->upload($mensaje);
		} else { // Si se realizo el upload, enviamos a importacion los datos
			$this->importacion($this->upload->data(), $this->_session_data['id_ente']);
		}
	}
	
/*--------------------------------------------------------------------------------	
 			Administración de Pagos: importacion de datos
 --------------------------------------------------------------------------------*/		
	
	function importacion($upload, $ente){
		$archivo_path = $upload['file_path'].$this->_session_data['usuario'].'-'.date('Y_m_d H_i_s').'.txt';
		rename($upload['file_path'].$upload['file_name'],  $archivo_path);
		$file = fopen($archivo_path, "r") or exit("Unable to open file!");
		
		$archivo = array(
			'nombre'		=> $this->_session_data['usuario'].'-'.date('Y_m_d H_i_s'),
			'extension'		=> $upload['file_ext'],
			'path'			=> $upload['file_path'],
			'size'			=> $upload['file_size'],
			'tipo'			=> $upload['file_type'],
			'full_path'		=> $archivo_path,
			'id_origen'		=> 1,
			'id_usuario'	=> $this->_session_data['id_usuario'],
			'id_ente'		=> $this->_session_data['id_ente'],
		);
		$id_archivo = $this->m_archivos->insert($archivo);
		
		$this->load->library('codigos/Pago_tarjetas');
		$pago_archivo = new Pago_tarjetas();
		
		while(!feof($file)) {
			$array_pago = $pago_archivo->parcear_linea(fgets($file));
			
			if($array_pago){
				$codigo_tarjeta = $this->m_tarjetas->getTarjeta($array_pago['codigo_barra'], $this->_session_data['id_ente']);
				if($codigo_tarjeta){
					foreach ($codigo_tarjeta as $row) {
						$array_tarjeta = (array) $row;
					}
					
					$registro = array(
						'id_tarjeta'		=> $array_tarjeta['id_tarjeta'],
						'agencia'			=> $array_pago['agencia'],
						'terminal'			=> $array_pago['terminal'],
						'nro_transaccion'	=> $array_pago['nro_transaccion'],
						'fecha_pago'		=> $array_pago['fecha_pago'],
						'importe'			=> formatFloat($array_pago['importe']),
						'id_archivo'		=> $id_archivo,
					);
				
					$insert = $this->m_pagos_tarjetas->insertPago($registro);
					
					if($insert == 0){
						if($this->_config['alerta_pago_no_ingresado_tarjetas'] == 1){
							$url = '<p><a href="'.base_url().'index.php/tarjetas/abm/'.$array_tarjeta['id_afiliado'].'">'.$this->lang->line('pago_ingresado_tarjeta').$array_tarjeta['id_afiliado'].'</a></p>';
							$this->alerta($url);
						}
					}
				
				}else{
					if($this->_config['alerta_codigo_no_existe_tarjetas'] == 1){
						$this->alerta($this->lang->line('codigo_no_existe').' '.$array_pago['codigo_barra']);
					}
				}
			}
			
		}
		fclose($file);
		
		$this->upload('update_ok');
	}
}