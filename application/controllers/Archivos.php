<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Archivos extends My_Controller {

	protected $_subject		= 'archivos';	
	
	function __construct(){

		parent::__construct(
			$subjet		= $this->_subject
		);
		
		$this->load->model('m_archivos');
		$this->load->model('m_config_archivos');
		$this->load->helper(array('form', 'url', 'download'));

	} 

/*--------------------------------------------------------------------------------	
 			Administración de archivos: tabla
 --------------------------------------------------------------------------------*/	
	
	function table($mensaje = NULL){
		
		if($mensaje != NULL) {
			$db['mensaje'] = $mensaje;
		}
		
		$this->load->library('Graficos');
		
		$db['registros']		= $this->m_archivos->getRegistros();
		$db['config_archivos']	= $this->m_config_archivos->getConfig();
			
		$this->armar_vista('table', $db);
	}

/*--------------------------------------------------------------------------------	
 			Administración de archivos: eliminación de archivos
 --------------------------------------------------------------------------------*/	
 	
	public function eliminar(){
		$registros	= $this->m_archivos->getRegistros();
 		
		if($this->input->post('archivos') === NULL){
			$this->table('no ha seleccionado archivos');
		}else{
			if($registros){
				foreach ($registros as $row) {
				if(in_array($row->id_archivo, $this->input->post('archivos'))){
						unlink($row->full_path);
						$this->m_archivos->delete($row->id_archivo);				
					}
				}	
			}
			
			$this->table('update_ok');
		}
	}
	
/*--------------------------------------------------------------------------------	
 			Administración de archivos: ajax para armar tabla
 --------------------------------------------------------------------------------*/	
 	
	public function ajax(){
		$registros	= $this->m_archivos->getRegistros();
		$json = "";
		if($registros){
			$title_usuario	= "'Ver usuario'";
			$title_ente		= "'Ver ente'";
			$class_check	= "'archivos'";
			$name_check		= "'archivos[]'";
			$type			= "'checkbox'";
			$url_usuario_i	= "'".base_url()."index.php/usuarios/abm/";
			$url_ente_i		= "'".base_url()."index.php/entes/abm/";
			foreach ($registros as $row) {
				$url_usuario_f = $row->id_usuario."'";
				$url_ente_f = $row->id_ente."'";
				$value_check = "'".$row->id_archivo."'";
				
				$json .= ' [ ';
				$json .= '"<div class='.$type.'><label><input type='.$type.' class='.$class_check.' name='.$name_check.' value='.$value_check.'> '.$row->nombre.'</label></div>", ';
				$json .= '"'.$row->extension.'", ';
				$json .= '"'.$row->tipo.'", ';
				$json .= '"'.formatBites($row->size).'", ';
				$json .= '"'.formatDateTime($row->date_add).'", ';
				$json .= '"<a title='.$title_usuario.' href='.$url_usuario_i.$url_usuario_f.'>'.$row->usuario.'</a>", ';
				$json .= '"<a title='.$title_ente.' href='.$url_ente_i.$url_ente_f.'>'.$row->ente.'</a>" ';
				$json .= ' ], ';
			}
			
			$json = substr($json, 0, -2);
		}
		echo '{ "data": ['.$json.' ]  }';
	}
}