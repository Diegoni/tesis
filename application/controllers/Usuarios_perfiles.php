<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios_perfiles extends MY_Controller 
{
	protected $_subject = 'usuarios_perfiles';
    protected $_model   = 'm_usuarios_perfiles';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');
        $this->load->model('m_usuarios_permisos');    
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {                           
        $db['campos']   = array(
            array('perfil',  array('unique', 'onlyChar'), 'required'),
        );
        
        $db['usuarios_permisos']    = $this->m_usuarios_permisos->getRegistros($id, 'id_perfil');
        $db['registros']            = $this->m_usuarios_permisos->getRegistros();
        
        $this->armarAbm($id, $db);
    }
    

/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       ABM de usuarios
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/  
    
    
    function afterInsert($registro, $id)
    {
        $permisos = $this->m_usuarios_permisos->getRegistros();
        
        foreach ($permisos as $row_permisos) 
        {
            $registro = array(
                'id_menu'   => $row_permisos->id_menu,
                'id_perfil' => $id,
                'ver'       => 1,
                'editar'    => 1,
            );
            
            $this->m_usuarios_permisos->insert($registro);
        }
    }    
}
?>