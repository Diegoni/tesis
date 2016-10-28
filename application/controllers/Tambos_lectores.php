<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tambos_lectores extends MY_Controller 
{
	protected $_subject = 'tambos_lectores';
    protected $_model   = 'm_tambos_lectores';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');
        $this->load->model('m_proveedores'); 
		$this->load->model('m_tambos_compuertas');    
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {                           
        $db['proveedores']  = $this->m_proveedores->getRegistros();
		$db['compuertas']  = $this->m_tambos_compuertas->getRegistros();
        
        $db['campos']   = array(
            array('lector',    '', 'required'),
            array('select',   'id_compuerta',  'compuerta', $db['compuertas']),
            array('checkbox', 'in_out'), 
            array('comentario',    '', ''),
            array('select',   'id_proveedor',  'proveedor', $db['proveedores']),
        );
        
        $this->armarAbm($id, $db);
    }
}
?>