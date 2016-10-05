<?php 
class m_usuarios extends MY_Model 
{		
	protected $_tablename	= 'usuarios';
	protected $_id_table	= 'id_usuario';
	protected $_order		= 'usuario';
	protected $_relation	= array(
		'id_perfil' => array(
			'table'		=> 'usuarios_perfiles',
			'subjet'	=> 'perfil'
		),
	);
		
	function __construct()
	{
		parent::__construct(
			$tablename		= $this->_tablename, 
			$id_table		= $this->_id_table, 
			$order			= $this->_order,
			$relation		= $this->_relation
		);
	}


/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Comprueba si usuario y pass coinciden
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/ 
		
	
	function login($username, $password)
	{
		//$password = encrypt($password);
        $password = md5($password);
		
		$sql = 
		"SELECT 
			*
		FROM 
			$this->_tablename
		WHERE
			usuario  = '$username' AND
			password = '$password' ";
		
		return $this->getQuery($sql);
	}
    

/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Guarda registro del login del usuario
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/     


	function logLogin()
	{
		$session_data		= $this->session->userdata('logged_in');
		$this->load->library('user_agent');
		if ($this->agent->is_browser()){
			$agent = $this->agent->browser();
		}else if ($this->agent->is_robot()){
	    	$agent = $this->agent->robot();
		}else if ($this->agent->is_mobile()) {
	    	$agent = $this->agent->mobile();
		} else {
	    	$agent = 'Unidentified User Agent';
		}
		
		$arreglo_campos = array(
			'last_login'	=> date('Y/m/d H:i:s'),
		//	'ip_login'		=> $this->input->ip_address(),
		//	'navegador'		=> $agent,
		//	'sistema'		=> $this->agent->platform(),
		);
        
        $where = array(
            'usuario'   => $session_data['usuario'],
        );
		
		$this->db->where($where);
		$this->db->update($this->_tablename, $arreglo_campos);
	}


/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Elimina todas las relaciones entre un usuario y los entes
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/ 	
	
	
	function truncateEntes($id_usuario)
	{
		$sql = 
		"DELETE FROM 
			entes_usuarios
		WHERE
			entes_usuarios.id_usuario = '$id_usuario'";
			
		$this->db->query($sql);
	}


/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Genera la relacion ente usuario
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/ 	
	

	function setEntes($id_ente, $id_usuario)
	{
		$arreglo = array(
			'id_ente'		=> $id_ente,
			'id_usuario'	=> $id_usuario
		);
		
		$arreglo = $this->getExtraField($arreglo);		
		
		$this->db->insert('entes_usuarios', $arreglo);
	}


/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Controla que el usuario no exista
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/ 	
	
	
	function controlUsuarios($usuario, $id_usuario = NULL)
	{
		$sql = 
		"SELECT
			*
		FROM
			$this->_tablename
		WHERE
			$this->_tablename.usuario = '$usuario'"; 	
			
		if($id_usuario != NULL){
			$sql .= "AND $this->_tablename.$this->_id_table != '$id_usuario'";
		}
		
		$query = $this->db->query($sql);
        
		if($query->num_rows() > 0){
			return 0;
		} else {
			return 1;
		}
	}
} 
?>