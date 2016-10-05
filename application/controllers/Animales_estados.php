<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Animales_estados extends MY_Controller 
{
	protected $_subject = 'animales_estados';
    protected $_model   = 'm_animales_estados';
    
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
            array('estado',    'onlyChar', 'required'),
        );
        
        $this->armarAbm($id, $db);
    }
}
?>