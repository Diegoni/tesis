<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tambos extends MY_Controller 
{
	protected $_subject = 'tambos';
    protected $_model   = 'm_tambos';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');
        $this->load->model('m_localidades');    
        $this->load->model('m_provincias');
        $this->load->model('m_empleados');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {                           
        $db['localidades']  = $this->m_localidades->getRegistros();
        $db['provincias']   = $this->m_provincias->getRegistros();
        $db['empleados']    = $this->m_empleados->getRegistros();
        
        $db['campos']   = array(
            array('tambo',    'onlyChar', 'required'),
            //array('select',   'id_localidades',  'localidad', $db['localidades']),
            array('select',   'id_provincia',  'provincia', $db['provincias']),
            array('calle',    '', ''),
            array('calle_numero',    '', ''),
            array('telefono',    '', ''),
            array('telefono_alternativo',    '', ''),
            array('web',    '', ''),
            array('select',   'id_encargado',  'apellidos', $db['empleados']),
        );
        
        $this->armarAbm($id, $db);                     // Envia todo a la plantilla de la pagina
    }
}
?>