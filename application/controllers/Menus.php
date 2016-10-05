<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menus extends MY_Controller 
{
	protected $_subject = 'menus'; 
    protected $_model   = 'm_menus';
    
    function __construct(){
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
        $this->load->model('m_usuarios');
        $this->load->model('m_usuarios_perfiles');
        $this->load->model('m_usuarios_permisos');
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
        
        $db['usuarios_permisos'] = $this->m_usuarios_permisos->getRegistros($id, 'id_perfil');
        $db['menus']    = $this->model->getRegistros('0', 'id_padre');
        
        $this->armarAbm($id, $db);
    }  
    

/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       ABM de usuarios
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/  
    
    
    function afterInsert($registro, $id)
    {
        $perfiles = $this->m_usuarios_perfiles->getRegistros();
        
        foreach ($perfiles as $row_perfil) 
        {
            $registro = array(
                'id_perfil' => $row_perfil->id_perfil,
                'id_menu'   => $id,
                'ver'       => 1,
                'editar'    => 1,
            );
            
            $this->m_usuarios_permisos->insert($registro);
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