<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Animales_rutinas extends MY_Controller 
{
	protected $_subject = 'animales_rutinas';
    protected $_model   = 'm_animales_rutinas';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');
        $this->load->model('m_animales_tipos');
        $this->load->model('m_tambos_sectores');
        $this->load->model('m_dias');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       ABM de animales
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {
        $db['animales_tipos']   = $this->m_animales_tipos->getRegistros();
        $db['sectores']         = $this->m_tambos_sectores->getRegistros();
        $db['dias']      = $this->m_dias->getRegistros();
                                         
        $db['campos']   = array(
            array('select',   'id_tipo',  'tipo', $db['animales_tipos']),
            array('select',   'id_sector',  'sector', $db['sectores']),
            array('select',   'id_dia',  'dia', $db['dias']),
            array('inicio',    '', ''),
            array('final',    '', ''),
            array('comentario',    '', ''),
        );
        
        $this->armarAbm($id, $db);                     // Envia todo a la plantilla de la pagina
    }
}
?>