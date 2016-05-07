<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarjetas extends My_Controller {

	protected $_subject		= 'tarjetas';
	
	function __construct(){
		parent::__construct(
				$subjet		= $this->_subject 
		);
		
		$this->load->model('m_archivos');
		$this->load->model('m_afiliados');
		$this->load->model('m_entes');
		$this->load->model('m_localidades');
		$this->load->model('m_provincias');
		$this->load->model('m_pagos_tarjetas');
		$this->load->model('m_tarjetas', 'm_model');

	} 
		
/*--------------------------------------------------------------------------------	
 			Alta masiva de tarjetas: Formulario
 --------------------------------------------------------------------------------*/

	public function alta(){
		$db['tarjetas']		= $this->m_model->getRegistros($this->_session_data['id_ente'], 'id_ente');
		$db['afiliados']	= $this->m_afiliados->getAfiliados($this->_session_data['id_ente']);
		
		$this->armar_vista('alta', $db);
	}
	
/*--------------------------------------------------------------------------------	
 			Alta masiva de tarjetas: Generación
 --------------------------------------------------------------------------------*/	
	
	public function generar_tarjetas(){
		if($this->input->post('afiliados')){
			foreach ($this->input->post('afiliados') as $id_afiliado) {
				$registro['id_ente'] = $this->_session_data['id_ente'];
				
				if($id_afiliado){
					$registro['id_afiliado'] = $id_afiliado;
					$codigo		= $this->m_model->insertTarjeta($registro);
					$tarjetas[] = $codigo;
				}
			};
			
			$this->generar_archivo($tarjetas, $registro['id_ente']);		
		}

		if($this->input->post('tarjetas')){
			foreach ($this->input->post('tarjetas') as $codigo_barra) {
				$tarjetas[] = $codigo_barra;
			};
			
			$this->generar_archivo($tarjetas);	
		}
	}
	
/*--------------------------------------------------------------------------------	
 			Crear Archivo: Formulario
 --------------------------------------------------------------------------------*/

	public function crear_archivo(){
		$db['registros']		= $this->m_model->getRegistros($this->_session_data['id_ente'], 'id_ente');
		
		$this->armar_vista('crear_archivo', $db);
	}	

/*--------------------------------------------------------------------------------	
 			Crear Archivo: Archivo
 --------------------------------------------------------------------------------*/
	
	public function generar_archivo($tarjetas, $id_ente = NULL){
		if($id_ente == NULL){
			$id_ente = $this->_session_data['id_ente'];
		}
			
		$archivo = base_url().'uploads/'.$this->_subject.'/'.$id_ente.'.txt';
		
		if('Linux' == PHP_OS){
			$path = str_replace('application/', '', APPPATH);
		} else {
			$path = str_replace('application\\', '', APPPATH);
			$path = str_replace('\\', '/', $path);
		}
		
		$path .= 'uploads/'.$this->_subject.'/';
		$archivo = $this->_subject.$id_ente.'-'.date('Y-m-d_H_i_s');
		$extencion = '.txt';
		$full_path = $path.$archivo.$extencion;
	
		$ar = fopen($path.$archivo.$extencion, "a") or die("Problemas en la creacion");
		foreach ($tarjetas as $tarjeta) {
			fputs($ar, $tarjeta);
			fputs($ar, chr(13).chr(10));
		}
		
		fclose($ar);
		
		$registro = array(
			'nombre'		=> $archivo,
			'extension'		=> $extencion,
			'path'			=> '../.'.$this->_upload.$this->_subject.'/',
			'size'			=> filesize($full_path),
			'tipo'			=> filetype($full_path),
			'full_path'		=> $full_path,
			'id_origen'		=> 2,
			'id_usuario'	=> $this->_session_data['id_usuario'],
			'id_ente'		=> 0,
		);
		
		$this->m_archivos->insert($registro);
  		
		$db['archivo']			= $registro['path'].$registro['nombre'].$registro['extension'];
		$this->armar_vista('archivo', $db);
	}
	
/*--------------------------------------------------------------------------------	
 			Administración de boletas: tabla
 --------------------------------------------------------------------------------*/	
	
	function table($id_afiliado = NULL){
		if($id_afiliado == NULL){
			$db['registros']	= $this->m_model->getTarjetas($this->_session_data['id_ente']);
			$db['id_afiliado']	= 0;
		}else if($id_afiliado == 0){
			$db['registros']	= $this->m_model->getTarjetas($this->_session_data['id_ente']);
			$db['id_afiliado']	= 0;
			$db['mensaje']		= 'update_ok';
		}else{
			$db['registros']	= $this->m_model->getTarjetas($this->_session_data['id_ente'], $id_afiliado);
			$db['id_afiliado']	= $id_afiliado;
		}
			
		$this->armar_vista('table', $db);
	}
	
/*--------------------------------------------------------------------------------	
 			Administración de boletas: ajax para armar tabla
 --------------------------------------------------------------------------------*/	
 	
	public function ajax($id_afiliado = NULL){
		if($id_afiliado == NULL){
			$registros	= $this->m_model->getTarjetas($this->_session_data['id_ente']);
		}else{
			$registros	= $this->m_model->getTarjetas($this->_session_data['id_ente'], $id_afiliado);
		}
		
		$json = "";
		if($registros){
			$btn_class			= "'btn btn-default'";
			$icon_class			= "'fa fa-pencil-square-o'";
			$title_modificar	= "'Ver'";
			$url_tar_i			= "'".base_url()."index.php/".$this->_subject."/abm/";
			$url_afi_i			= "'".base_url()."index.php/afiliados/abm/";
			
			foreach ($registros as $row) {
				$url_tar_f = $row->id_afiliado."'";
				$url_afi_f = $row->id_afiliado."'";
				
				if($row->eliminado == 0){
					$button = ' <a class='.$btn_class.' title='.$title_modificar.' href='.$url_tar_i.$url_tar_f.'><i class='.$icon_class.'></i></a>';	
				}else{
					$button = estadoPago(-1);
				}
				
				$registro = array(
					$row->codigo_barra,
					'<a href='.$url_afi_i.$url_afi_f.'>'.$row->apellido.' '.$row->nombre.'</a>',
					$button,
				);
				
				$json .= setJsonContent($registro);
			}
			
			$json = substr($json, 0, -2);
		}
		echo '{ "data": ['.$json.' ]  }';
	}
	
/*--------------------------------------------------------------------------------	
 			Administración de boletas: registro
 --------------------------------------------------------------------------------*/	
	
	function abm($id = NULL){
		if($this->input->post('id_afiliado')){
			$deleteTarjetas = $this->m_model->getTarjetas($this->_session_data['id_ente'], $this->input->post('id_afiliado'));
			foreach ($deleteTarjetas as $row) {
				$this->m_model->delete($row->id_tarjeta);	
			}
			redirect($this->_subject.'/table/0', 'refresh');
		}else{
			$this->load->library('Graficos');
			$db['registros']		= $this->m_pagos_tarjetas->getPagos($id);
			$db['afiliados']		= $this->m_afiliados->getRegistros($id);
			$db['id_afiliado']		= $id;
			$this->armar_vista('abm', $db);	
		}
	}

}