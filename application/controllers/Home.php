<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends My_Controller {

	protected $_subject		= 'home';
	
	function __construct(){
		parent::__construct(
				$subject		= $this->_subject 
		);
		
		$this->load->model('m_archivos');
		$this->load->model('m_config_archivos');
		$this->load->model('m_entes');
		$this->load->model('m_usuarios');
		$this->load->model('m_boletas');
		$this->load->model('m_feriados');
		$this->load->model('m_lotes');
	} 
	
/*--------------------------------------------------------------------------------	
 			Pantalla de inicio: pantalla de inicio y redireccion 
 --------------------------------------------------------------------------------*/	
	
	public function index(){	
		if($this->session->userdata('logged_in')){
			$session_data = $this->session->userdata('logged_in');
			
			if($session_data['id_perfil'] == 2){
				$db['registros'] = $this->m_entes->getEntes($session_data['id_usuario']);
				
				if(!$db['registros']){
					$url = '<p><a href="'.base_url().'index.php/usuarios/abm/'.$session_data['id_usuario'].'">'.$this->lang->line('usuario_sin_entes').'</a></p>';
					$this->alerta_banco($url);
					$this->load->view('plantilla/head', $db);
					$this->load->view($this->_subject.'/home');
					
				}else if(count($db['registros']) == 1){
					foreach ($db['registros'] as $row) {
						$id_ente = $row->id_ente;
					}
					$this->ente($id_ente);
				}else{
					$this->load->view('plantilla/head', $db);
					$this->load->view($this->_subject.'/home');
				}
			}else{
				$this->banco();
			}	
		}
	}
	 
/*--------------------------------------------------------------------------------	
 			Pantalla de inicio: seleccion de ente
 --------------------------------------------------------------------------------*/		 
	 
	public function ente($id_ente = NULL){
		if($this->session->userdata('logged_in')){
			$session_data = $this->session->userdata('logged_in');
			$db['registros'] = $this->m_entes->getEntes($session_data['id_usuario']);
			
			if($id_ente == NULL){
				if($session_data['id_ente'] != NULL){
					$id_ente = $session_data['id_ente'];
				} else {
					$id_ente = 0;
				}
			}else{
				$db['mensajes']	= $this->lang->line('ente_seleccionado');
			}
			
			if($id_ente != 0){
				$ente = $this->m_entes->getRegistros($id_ente);
			
				foreach ($ente as $row) {
					$ente_seleccionado = array(
						'imagen'	=> base_url().'uploads/img/'.$row->img,
						'nombre'	=> $row->nombre,
						'boletas'	=> $row->boletas,
						'tarjetas'	=> $row->tarjetas,
					);
					
				}
				
				foreach ($db['registros'] as $row) {
					$registro = array(
						'id_ente'	=> $row->id_ente,
						'codigo'	=> $row->codigo,
						'ente'		=> $row->nombre,
					);
					
					$entes[] = $registro;	
				}
				
				$sess_array = array(
					'id_usuario' 	=> $session_data['id_usuario'],
					'usuario' 		=> $session_data['usuario'],
					'id_perfil'		=> $session_data['id_perfil'],
					'date_add'		=> $session_data['date_add'],
					'id_ente'		=> $id_ente,
					'ente'			=> $ente_seleccionado['nombre'],
					'imagen'		=> $ente_seleccionado['imagen'],
					'boletas'		=> $ente_seleccionado['boletas'],
					'tarjetas'		=> $ente_seleccionado['tarjetas'],
					'entes'			=> $entes,
			    );
				 
				$this->session->unset_userdata('logged_in');
				$this->session->set_userdata('logged_in', $sess_array);
			}
			$session_data = $this->session->userdata('logged_in');
			$db['lotes']	= $this->m_lotes->getRegistros($session_data['id_ente'], 'id_ente');
			$db['feriados']	= $this->m_feriados->getRegistros();
			
			$this->armar_vista('home', $db, $this->session->userdata('logged_in'));
		}
	}

/*--------------------------------------------------------------------------------	
 			Pantalla de inicio: carga de datos banco
 --------------------------------------------------------------------------------*/	

	function banco(){
		if($this->session->userdata('logged_in')){
			$session_data = $this->session->userdata('logged_in');
			
			$sess_array = array(
				'id_usuario' 	=> $session_data['id_usuario'],
				'usuario' 		=> $session_data['usuario'],
				'id_perfil'		=> $session_data['id_perfil'],
				'date_add'		=> $session_data['date_add'],
				'id_ente'		=> 0,
				'ente'			=> 'Administrador',
				'imagen'		=> 0,
		    );
			
			$archivos = $this->m_archivos->getRegistros();
			$config_a = $this->m_config_archivos->getConfig();
			$total_size = 0;
			if($archivos){
				foreach ($archivos as $row) {
					$total_size = $total_size + $row->size;
				}
				if($total_size > $config_a['mensaje_danger']){
					$url = '<a class="warning" href="'.base_url().'index.php/archivos/table"><i class="fa fa-exclamation-triangle"></i>'.$this->lang->line('necesita').' '.$this->lang->line('eliminar_archivos').'</a>';
					$this->alerta_banco($url);
					$this->emailAdmin($url);
				}else if($total_size > $config_a['mensaje_warning']){
					$url = '<a class="danger" href="'.base_url().'index.php/archivos/table"><i class="fa fa-exclamation-triangle"></i>'.$this->lang->line('deberia').' '.$this->lang->line('eliminar_archivos').'</a>';
					$this->alerta_banco($url);
					$this->emailAdmin($url);
				}	
			}
			 
			$this->session->unset_userdata('logged_in');
			$this->session->set_userdata('logged_in', $sess_array);
			
			$this->home_banco();
		}
	}
	
/*--------------------------------------------------------------------------------	
 			Pantalla de inicio: carga de home de banco
 --------------------------------------------------------------------------------*/	
	
	function home_banco(){
		$this->load->library('Graficos');
		$this->load->library('Calendarios');
		$db['dias_cantidades']	= 7;
		
		$fecha = date('Y-m-d');
		$nuevafecha = strtotime ( '+'.$db['dias_cantidades'].' day' , strtotime ( $fecha ) ) ;
		$nuevafecha = date ( 'Y-m-d' , $nuevafecha );

			
		$db['cant_entes']		= $this->m_entes->getCantidad();
		$db['leyendas']			= $this->m_entes->getRegistros();
		$db['cant_usuarios']	= $this->m_usuarios->getCantidad();
		$db['usuarios']			= $this->m_usuarios->getRegistros();
		$db['feriados']			= $this->m_feriados->getRegistros();
		$db['logs']				= $this->m_usuarios->getLast(5, 2, 'id_perfil');
		$db['lotes']			= $this->m_lotes->getFecha($nuevafecha);
					
		$this->armar_vista('banco', $db, $this->session->userdata('logged_in'));
	}
	
}
