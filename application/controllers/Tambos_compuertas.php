<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tambos_compuertas extends MY_Controller 
{
	protected $_subject = 'tambos_compuertas';
    protected $_model   = 'm_tambos_compuertas';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');
        $this->load->model('m_proveedores');    
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {                           
        $db['proveedores']  = $this->m_proveedores->getRegistros();
        
        $db['campos']   = array(
            array('compuerta',    '', 'required'),
            array('comentario',    '', ''),
            array('select',   'id_proveedor',  'proveedor', $db['proveedores']),
        );
        
        $this->armarAbm($id, $db);
    }
}
?>