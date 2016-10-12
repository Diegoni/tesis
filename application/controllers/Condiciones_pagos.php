<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Condiciones_pagos extends MY_Controller 
{
	protected $_subject = 'condiciones_pagos';
    protected $_model   = 'm_condiciones_pagos';
    
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
            array('condicion_pago',    'onlyChar', 'required'),
            array('dias',    'onlyInt', ''),
        );
        
        $this->armarAbm($id, $db);
    }
}
?>