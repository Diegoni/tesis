<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empleados extends MY_Controller 
{
	protected $_subject = 'empleados';
    protected $_model   = 'm_empleados';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
        $this->load->model('m_empleados_puestos');
        $this->load->model('m_localidades');
        $this->load->model('m_provincias');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {
        $db['puestos'] = $this->m_empleados_puestos->getRegistros();
        $db['localidades'] = $this->m_localidades->getRegistros();
        $db['provincias'] = $this->m_provincias->getRegistros();
        $db['empleados'] = $this->model->getRegistros();
                                   
        $db['campos']   = array(
            //array('select',     'id_encargado',  'apellidos', $db['empleados']),
            array('select',     'id_puesto',  'puesto', $db['puestos']),
            array('empleado',  'onlyChar', 'required'),
            array('dni',    'onlyInt', 'required'),
            array('telefono',    '', ''),
            array('telefono_alternativo', '', ''),
            array('email', '', ''),
            array('select',     'id_localidad',  'localidad', $db['localidades']),
            array('select',     'id_provincia',  'provincia', $db['provincias']),
            array('calle', '', ''),
            array('calle_numero', '', ''),
        );
        
        $this->armarAbm($id, $db);
    }
}
?>