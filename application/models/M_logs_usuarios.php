<?php 
class m_logs_usuarios extends MY_Model {
		
	protected $_tablename	= 'logs_usuarios';
	protected $_id_table	= 'id_log';
	protected $_order		= 'fecha DESC';
	protected $_relation	= array(
		'id_usuario' => array(
			'table'		=> 'usuarios',
			'subjet'	=> 'usuario'
		),
	);
		
	function __construct(){
		parent::__construct(
			$tablename		= $this->_tablename, 
			$id_table		= $this->_id_table, 
			$order			= $this->_order,
			$relation		= $this->_relation
		);
	}
	
/*--------------------------------------------------------------------------------	
 			Guarda el log de la acción y los datos relacionados
 --------------------------------------------------------------------------------*/		
	
	function action($action){
		$session_data		= $this->session->userdata('logged_in');
		if($session_data){
			if($action == 'log in'){
				$this->load->library('user_agent');
				if ($this->agent->is_browser()){
					$agent = $this->agent->browser().' - '.$this->agent->version();
				}else if ($this->agent->is_robot()){
		    		$agent = $this->agent->robot();
				}else if ($this->agent->is_mobile()) {
		    		$agent = $this->agent->mobile();
				} else {
		    		$agent = 'Unidentified User Agent';
				}
				$arreglo_campos = array(
					'id_usuario'	=> $session_data['id_usuario'],
					'fecha'			=> date('Y/m/d H:i:s'),
					'ip_login'		=> $this->input->ip_address(),
					'action'		=> $action,
					'tabla'			=> $agent,
					'registro'		=> $this->agent->platform(),
				);	
			}else{
				$arreglo_campos = array(
					'id_usuario'	=> $session_data['id_usuario'],
					'fecha'			=> date('Y/m/d H:i:s'),
					'ip_login'		=> $this->input->ip_address(),
					'action'		=> $action
				);	
			}
			
			$this->insert($arreglo_campos);
		}
	}
} 
?>