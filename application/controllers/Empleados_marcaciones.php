<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empleados_marcaciones extends MY_Controller 
{
	protected $_subject = 'empleados_marcaciones';
    protected $_model   = 'm_empleados_marcaciones';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
        $this->load->model('m_empleados');
        $this->load->model('m_tambos_sectores');
        $this->load->model('m_empleados_marcaciones_tipos');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {                           
        $db['empleados']    = $this->m_empleados->getRegistros();
        $db['sectores']     = $this->m_tambos_sectores->getRegistros();
        $db['tipos']        = $this->m_empleados_marcaciones_tipos->getRegistros();
        
        $db['campos']   = array(
            array('select',   'id_empleado',  'empleado', $db['empleados']),
            array('select',   'id_sector',  'sector', $db['sectores']),
            array('marcacion',    '', 'required'),
            array('select',   'id_tipo',  'tipo', $db['tipos']),
            array('comentario',    '', ''),
        );
        
        $this->armarAbm($id, $db);    
    }
}
?>