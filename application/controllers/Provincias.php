<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Provincias extends MY_Controller 
{
	protected $_subject = 'provincias';
    protected $_model   = 'm_provincias';
    
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
            array('provincia',    'onlyChar', 'required'),
        );
        
        $this->armarAbm($id, $db);
    }
}
?>