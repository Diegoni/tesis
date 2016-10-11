<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empleados_turnos extends MY_Controller 
{
	protected $_subject = 'empleados_turnos';
    protected $_model   = 'm_empleados_turnos';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
        $this->load->model('m_empleados_puestos');
        $this->load->model('m_tambos_sectores');
        $this->load->model('m_dias');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {                           
        $db['puestos']    = $this->m_empleados_puestos->getRegistros();
        $db['sectores']   = $this->m_tambos_sectores->getRegistros();
        $db['dias']       = $this->m_dias->getRegistros();
        
        $db['campos']   = array(
            array('select',   'id_puesto',  'puesto', $db['puestos']),
            array('select',   'id_sector',  'sector', $db['sectores']),
            array('select',   'id_dia',  'dia', $db['dias']),
            array('ingreso',    '', 'required'),
            array('egreso',    '', 'required'),
            array('comentario',    '', ''),
        );
        
        $this->armarAbm($id, $db);    
    }
}
?>