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
        
        $db['campos']   = array(
            array('select',   'id_empleado',  array('apellidos', 'nombres'), $db['empleados']),
            array('select',   'id_sector',  'sector', $db['sectores']),
            array('fecha_ingreso',    '', 'required'),
            array('fecha_egreso',    '', 'required'),
            array('comentario',    '', 'required'),
        );
        
        $this->armarAbm($id, $db);    
    }
}
?>