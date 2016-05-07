<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends My_Controller {

	protected $_subject		= 'usuarios';
	
	function __construct(){
		parent::__construct(
				$subjet		= $this->_subject 
		);
		
		$this->load->model('m_entes');
		$this->load->model('m_perfiles');
		$this->load->model('m_usuarios');
	} 
		
	
/*--------------------------------------------------------------------------------	
 			Administración de Usuarios: datos de perfil
 --------------------------------------------------------------------------------*/	

	function perfil(){
		$db['usuarios'] = $this->m_usuarios->getRegistros($this->_session_data['id_usuario']);
		
		$this->armar_vista('perfil', $db);
	}
	
/*--------------------------------------------------------------------------------	
 			Administración de Usuarios: table
 --------------------------------------------------------------------------------*/	
	
	function table($mensaje = NULL){
		$db['registros']	= $this->m_usuarios->getRegistros();
		if($mensaje != NULL){
			$db['mensaje']		= $mensaje;
		}
		$this->armar_vista('table', $db);
	}
	
/*--------------------------------------------------------------------------------	
 			Administración de Usuarios: registro
 --------------------------------------------------------------------------------*/		
	
	public function abm($id = NULL){
		$vista 				= '';
		$db['seccion']		= 'usuario';	
		$db['secciones']	= array('usuario', 'entes');
		$db['fields']		= $this->m_usuarios->getFields();
		$id_table			= $this->m_usuarios->getId_Table();
		
		// DELETE 
		
		if($this->input->post('eliminar')){
			$this->m_usuarios->delete($this->input->post($id_table));
			$db['mensaje']	= 'update_ok';
			$vista = 'table';
		}
		
		// RESTAURAR
		
		if($this->input->post('restaurar')){
			$this->m_usuarios->restore($this->input->post($id_table));
			$db['mensaje']	= 'update_ok';
			$vista = 'table';
		}
		
		// UPDATE
		
		if($this->input->post('modificar')){
			foreach ($db['fields'] as $field) {
				if($this->input->post($field) !== NULL){
					if($field == 'pass'){
						$registro[$field] = encrypt($this->input->post($field));
					}else{
						$registro[$field] = $this->input->post($field);
					}
				}
			}
			
			if($this->input->post('id_perfil') == 2){
				$this->m_usuarios->truncateEntes($this->input->post($id_table));
			}
			
			if($this->input->post('entes')){
				foreach ($this->input->post('entes') as $id_ente) {
					$this->m_usuarios->setEntes($id_ente, $this->input->post($id_table));
				}
			}
			
			$this->m_usuarios->update($registro, $this->input->post($id_table));
			$db['mensaje']	= 'update_ok';
			$vista = 'table';
		}
					
		// INSERT 
			
		if($this->input->post('agregar') || $this->input->post('agregar_per')){
			foreach ($db['fields'] as $field) {
				if($this->input->post($field) !== NULL){
					if($field == 'pass'){
						$registro[$field] = encrypt($this->input->post($field));
					}else{
						$registro[$field] = $this->input->post($field);
					}
				}
			}
			
			$id = $this->m_usuarios->insert($registro);
			$db['mensaje']	= 'insert_ok';
			
			if($this->input->post('id_perfil') == 2){
				$db['seccion']		= 'entes';	
				$db['mensajes']		= $this->lang->line('seleccione_entes');
			}else if($this->input->post('agregar')){
				$vista = 'table';
			}
		}
		
		if($id){
			$db['registro'] = $this->m_usuarios->getRegistros($id);	
		}else{
			$db['registro'] = FALSE;
		}
		
		// ARMADO DE VISTA
		
		if($vista != 'table'){
			$db['perfiles']		= $this->m_perfiles->getRegistros();
			$db['entes']		= $this->m_entes->getRegistros();
			$db['entes_asoc']	= $this->m_entes->getEntes($id);
			$this->armar_vista('abm', $db);
		}else{
			$this->table($db['mensaje']);
		}
	}

/*--------------------------------------------------------------------------------	
 			Administración de Usuarios: logs
 --------------------------------------------------------------------------------*/	
	
	function logs($id){
		$db['registros'] = $this->m_logs_usuarios->getLast(500, $id, 'id_usuario');
		
		$this->armar_vista('logs', $db);
	}

/*--------------------------------------------------------------------------------	
 			Funciones ajax: control de usuario
 --------------------------------------------------------------------------------*/	

	function control_usuarios(){
		if($this->input->post('usuario') == ''){
			echo 2;
		}else{
			echo $this->m_usuarios->control_usuarios($this->input->post('usuario'), $this->input->post('id_usuario'));
		}
	}
}