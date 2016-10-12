<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Formas_pagos extends MY_Controller 
{
	protected $_subject = 'formas_pagos';
    protected $_model   = 'm_formas_pagos';
    
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
            array('forma_pago',    'onlyChar', 'required'),
        );
        
        $this->armarAbm($id, $db);
    }
}
?>