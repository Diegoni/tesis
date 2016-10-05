<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tambos_sectores_tipos extends MY_Controller 
{
	protected $_subject = 'tambos_sectores_tipos';
    protected $_model   = 'm_tambos_sectores_tipos';
    
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
            array('tipo',    '', 'required'),
        );
        
        $this->armarAbm($id, $db);
    }
}
?>