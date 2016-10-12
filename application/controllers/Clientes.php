<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clientes extends MY_Controller 
{
	protected $_subject = 'clientes';
    protected $_model   = 'm_clientes';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
        $this->load->model('m_clientes_tipos');
        $this->load->model('m_formas_juridicas');
        $this->load->model('m_empleados');
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
        $db['tipos']        = $this->m_clientes_tipos->getRegistros();
        $db['formas']       = $this->m_formas_juridicas->getRegistros();
        $db['empleados']    = $this->m_empleados->getRegistros();
        $db['localidades']  = $this->m_localidades->getRegistros();
        $db['provincias']   = $this->m_provincias->getRegistros();
        
        $db['campos']   = array(
            array('cliente',    '', 'required'),
            array('select',   'id_tipo',  'tipo', $db['tipos']),
            array('email',    '', ''),
            array('telefono',    '', ''),
            array('telefono_alternativo',    '', ''),
            array('web',    '', ''),
            array('select',   'id_forma_juridica',  'forma_juridica', $db['formas']),
            array('select',   'id_empleado',  'empleado', $db['empleados']),
            array('calle',    '', ''),
            array('calle_numero',    '', ''),
            array('select',   'id_provincia',  'provincia', $db['provincias']),
            array('comentario',    '', ''),
        );
        
        $this->armarAbm($id, $db);
    }
}
?>