<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pagos_boletas extends My_Controller {

	protected $_subject		= 'pagos_boletas';
	
	function __construct(){
		parent::__construct(
				$subjet		= $this->_subject 
		);
		
		$this->load->model('m_archivos');
		$this->load->model('m_boletas');
		$this->load->model('m_config_archivos');
		$this->load->model('m_pagos_boletas');
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
		
		$this->load->library('codigos/Pago_boletas');
		$pago_archivo = new Pago_boletas();
		
		while(!feof($file)) {
			$array_pago = $pago_archivo->parcear_linea(fgets($file));
			
			if($array_pago){
				$codigo_boleta = $this->m_boletas->getCodigo($array_pago['codigo_barra'], $this->_session_data['id_ente']);
			
				if($codigo_boleta['id_boleta'] != 0){
					if($codigo_boleta['pago'] == 0){
						$registro = array(
							'id_boleta'			=> $codigo_boleta['id_boleta'],
							'agencia'			=> $array_pago['agencia'],
							'terminal'			=> $array_pago['terminal'],
							'nro_transaccion'	=> $array_pago['nro_transaccion'],
							'fechapago'			=> $array_pago['fechapago'],
							'importe'			=> formatFloat($array_pago['importe']),
							'codigo_pago'		=> $array_pago['codigo_pago'],
							'id_archivo'		=> $id_archivo,
						);
						
						$this->m_pagos_boletas->insert($registro);
						
						$registro = array(
							'pago'	=> 1,
						);			
								
						$this->m_boletas->update($registro, $codigo_boleta['id_boleta']);
						
						if($this->_config['alerta_pago_iguales'] == 1){
							$pagos_iguales	= 0;
							$fecha_2		= date('Ymd', strtotime($codigo_boleta['fecha_venc_2']));
							$importe		= floatval(formatFloat($array_pago['importe']));
							
							if($this->_config['comparar_decimales'] == 0){
								$importe		= intval($importe);
								$codigo_boleta['importe_venc_1'] = intval($codigo_boleta['importe_venc_1']);
								$codigo_boleta['importe_venc_2'] = intval($codigo_boleta['importe_venc_2']);
							}
							
							if($array_pago['fechapago'] < $fecha_2){
								if ($importe != $codigo_boleta['importe_venc_1']){
									$pagos_iguales = 1;
								}
							} else {
								if ($importe != $codigo_boleta['importe_venc_2']){
									$pagos_iguales = 1;
								}
							}	
							
							if($pagos_iguales == 1){
								$url = '<p><a href="'.base_url().'index.php/boletas/abm/'.$codigo_boleta['id_boleta'].'">'.$this->lang->line('pago_no_igual').$codigo_boleta['id_boleta'].'</a></p>';
								$this->alerta($url);
							}	
						}
					}else{
						if($this->_config['alerta_pago_no_ingresado'] == 1){
							$url = '<p><a href="'.base_url().'index.php/boletas/abm/'.$codigo_boleta['id_boleta'].'">'.$this->lang->line('pago_ingresado').$codigo_boleta['id_boleta'].'</a></p>';
							$this->alerta($url);
						}
					}
				}else{
					if($this->_config['alerta_codigo_no_existe'] == 1){
						$this->alerta($this->lang->line('codigo_no_existe').' '.$array_pago['codigo_barra']);
					}
				}
			}
		}
		fclose($file);
		
		$this->upload('update_ok');
	}
}