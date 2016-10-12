<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Formas_juridicas extends MY_Controller 
{
	protected $_subject = 'formas_juridicas';
    protected $_model   = 'm_formas_juridicas';
    
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
            array('forma_juridica',    'onlyChar', 'required'),
        );
        
        $this->armarAbm($id, $db);
    }
}
?>