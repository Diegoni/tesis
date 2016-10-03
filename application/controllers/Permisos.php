<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permisos extends MY_Controller 
{
	protected $_subject = 'permisos'; 
    protected $_model   = 'm_permisos';
    
    function __construct(){
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
        $this->load->model('m_roles');
        $this->load->model('m_usuarios');
        $this->load->model('m_roles_permisos');
    } 
    

    function esquema($id = NULL)
    {
        $db['permisos']    = $this->model->getRegistros();
        
        $this->armarVista('esquema', $db);
    }      
 
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       ABM de usuarios
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
 
    
    function abm($id = NULL)
    {
        $db['campos']   = array(
            array('menu',   'onlyChar' , 'required'),
            array('icon',   '' , ''),
            array('url',    '', 'disabled'),
        );
        
        $db['roles_permisos'] = $this->m_roles_permisos->getRegistros($id, 'id_permiso');
        $db['permisos']    = $this->model->getRegistros('0', 'id_padre');
        
        $this->armarAbm($id, $db);
    }  
    

/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       ABM de usuarios
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/  
    
    
    function afterInsert($registro, $id)
    {
        $roles = $this->m_roles->getRegistros();
        
        foreach ($roles as $row_rol) 
        {
            $registro = array(
                'id_rol'    => $row_rol->id_rol,
                'id_permiso'=> $id,
                'ver'       => 1,
                'editar'    => 1,
            );
            
            $this->m_roles_permisos->insert($registro);
        }
    }
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Funciones ajax: control de usuario
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/ 


    function cambiarPermiso()
    {
        $registro = array(
            $this->input->post('campo') => $this->input->post('valor'),
        );
        
        $this->m_roles_permisos->update($registro, $this->input->post('id_rol_permiso'));
        
        echo $this->input->post('campo')." => ".$this->input->post('valor').' '.$this->input->post('id_rol_permiso');
    }
    
}    
?>