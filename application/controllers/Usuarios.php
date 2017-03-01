<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends MY_Controller 
{
	protected $_subject = 'usuarios';
    protected $_model   = 'm_usuarios';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
        $this->load->model('m_usuarios_perfiles');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)                             
    {
        $db['perfiles']    = $this->m_usuarios_perfiles->getRegistros();
                                   
        $db['campos']   = array(
            array('usuario',  'onlyChar', 'required'),
            array('nombre',   'onlyChar', ''),
            array('apellido', 'onlyChar', ''), 
            array('select',   'id_perfil',  'perfil', $db['perfiles'], 'required'),  
        );
        
        $this->armarAbm($id, $db);                     // Envia todo a la plantilla de la pagina
    }
	
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Login 
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function login()                             
    {
    	$user = $this->input->post('usu');
		$pass = $this->input->post('pass');
		
		log_message('DEBUG', '--------------------------- Login Usuario');

		$id_usuarios = $this->model->login($user, $pass);
		if($id_usuarios)
		{
			log_message('DEBUG', 'Login de '.$user);
			echo 1;
		}else
		{
			log_message('DEBUG', 'No existe '.$user);
	    	echo false;	
		}
		
	}
}
?>