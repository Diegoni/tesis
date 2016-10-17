<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empleados_puestos extends MY_Controller 
{
	protected $_subject = 'empleados_puestos';
    protected $_model   = 'm_empleados_puestos';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {                           
        $db['campos']   = array(
            array('puesto',    'onlyChar', 'required'),
            array('comentario','', ''),
        );
        
        $this->armarAbm($id, $db);
    }
}
?>