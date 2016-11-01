<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tambos_sectores extends MY_Controller 
{
	protected $_subject = 'tambos_sectores';
    protected $_model   = 'm_tambos_sectores';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');
        $this->load->model('m_tambos');    
        $this->load->model('m_tambos_sectores_tipos');
        $this->load->model('m_empleados');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {                           
        $db['tambos']    = $this->m_tambos->getRegistros();
        $db['tipos']     = $this->m_tambos_sectores_tipos->getRegistros();
        $db['empleados']    = $this->m_empleados->getRegistros();
        
        $db['campos']   = array(
            array('select',   'id_tambo',  'tambo', $db['tambos']),
            array('select',   'id_tipo',  'tipo', $db['tipos']),
            array('sector',    '', 'required'),
            array('x',    '', ''),
            array('y',    '', ''),
            array('width',    '', ''),
            array('height',    '', ''),
            array('comentario',    '', ''),
            array('select',   'id_empleado',  'empleado', $db['empleados']),
        );
        
        $this->armarAbm($id, $db);
    }
}
?>