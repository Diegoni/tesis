<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Origenes extends MY_Controller 
{
	protected $_subject = 'origenes';
    protected $_model   = 'm_origenes';
    
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
            array('origen',    'onlyChar', 'required'),
        );
        
        $this->armarAbm($id, $db);
    }
}
?>