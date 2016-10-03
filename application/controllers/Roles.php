<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Roles extends MY_Controller 
{
	protected $_subject = 'roles';
    protected $_model   = 'm_roles';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');
        $this->load->model('m_permisos');    
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {                           
        $db['campos']   = array(
            array('rol',  array('unique', 'onlyChar'), 'required'),
        );
        
        $db['roles_permisos']  = $this->m_roles_permisos->getRegistros($id, 'id_rol');
        $db['registros']       = $this->m_permisos->getRegistros();
        
        $this->armarAbm($id, $db);
    }
    

/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       ABM de usuarios
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/  
    
    
    function afterInsert($registro, $id)
    {
        $permisos = $this->m_permisos->getRegistros();
        
        foreach ($permisos as $row_permisos) 
        {
            $registro = array(
                'id_permiso'=> $row_permisos->id_permiso,
                'id_rol'    => $id,
                'ver'       => 1,
                'editar'    => 1,
            );
            
            $this->m_roles_permisos->insert($registro);
        }
    }    
}
?>