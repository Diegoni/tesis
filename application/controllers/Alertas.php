<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alertas extends My_Controller {

	protected $_subject		= 'alertas';
	
	function __construct(){
		parent::__construct(
				$subjet		= $this->_subject 
		);
	} 

/*--------------------------------------------------------------------------------	
 			Funciones para ajax: marca como leidas las del ente
 --------------------------------------------------------------------------------*/
 
	public function marcar_leidas(){
		if($this->input->post('id_perfil') == 1){
			$this->m_alertas->setVistas($this->input->post('id_usuario'));
		} else {
			$this->m_alertas->setVistas($this->input->post('id_usuario'), $this->input->post('id_ente'));
		}
		
	}
}