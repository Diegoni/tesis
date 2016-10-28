<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ingresos extends MY_Controller 
{
	protected $_subject = 'ingresos';
    protected $_model   = 'm_ingresos';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
        $this->load->model('m_animales');
        $this->load->model('m_tambos_sectores');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {                           
        $db['animales']    = $this->m_animales->getRegistros();
        $db['sectores']    = $this->m_tambos_sectores->getRegistros();
        
        $db['campos']   = array(
            array('select',   'id_animal',  'animal', $db['animales']),
            array('select',   'id_sector',  'sector', $db['sectores']),
        );
        
        $this->armarAbm($id, $db);                     // Envia todo a la plantilla de la pagina
    }
}
?>