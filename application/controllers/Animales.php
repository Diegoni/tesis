<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Animales extends MY_Controller 
{
	protected $_subject = 'animales';
    protected $_model   = 'm_animales';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');
        $this->load->model('m_animales_tipos');
        $this->load->model('m_proveedores');
        $this->load->model('m_animales_estados');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       ABM de animales
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {
        $db['animales_tipos']   = $this->m_animales_tipos->getRegistros();
        $db['animales']         = $this->model->getRegistros();
        $db['proveedores']      = $this->m_proveedores->getRegistros();
        $db['animales_estados'] = $this->m_animales_estados->getRegistros();
                                         
        $db['campos']   = array(
        	array('animal',    '', 'required'),
        	array('tarjeta',    '', 'required'),
            array('select',   'id_tipo',  'tipo', $db['animales_tipos']),
            array('select',   'id_padre',  'animal', $db['animales']),
            array('select',   'id_madre',  'animal', $db['animales']),
            array('select',   'id_proveedor',  'proveedor', $db['proveedores']),
            array('fecha_ingreso',    '', 'required'),
            array('fecha_nacimiento',    '', ''),
            array('peso',      'onlyFloat', 'required'),
            array('altura',    'onlyFloat', 'required'),
            array('comentario',    '', ''),
            array('select',   'id_estado',  'estado', $db['animales_estados']),
        );
        
        $this->armarAbm($id, $db);                     // Envia todo a la plantilla de la pagina
    }


/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Estadisticas
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function estadisticas()
    {
   		$registros    = $this->model->getRegistros(); 
			
		if($registros)
		{
			echo json_encode($registros);
		}                                             
    }
}
?>