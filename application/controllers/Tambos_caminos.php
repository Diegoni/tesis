<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tambos_caminos extends MY_Controller 
{
	protected $_subject = 'tambos_caminos';
    protected $_model   = 'm_tambos_caminos';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');
        $this->load->model('m_tambos_compuertas');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)                         
    {                           
        $db['compuertas']    = $this->m_tambos_compuertas->getRegistros(); 
        $this->armarVista('abm', $db);
    }
}
?>