<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Envios extends MY_Controller 
{
	protected $_subject = 'envios';
    protected $_model   = 'm_envios';
    
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
            array('envio',    'onlyChar', 'required'),
        );
        
        $this->armarAbm($id, $db);
    }
}
?>