<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Seguimientos extends MY_Controller 
{
	protected $_subject = 'seguimientos';
    protected $_model   = 'm_seguimientos';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
        $this->load->model('m_animales');
        $this->load->model('m_seguimientos_estados');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {                           
        $db['animales']    = $this->m_animales->getRegistros();
        $db['estados']    = $this->m_seguimientos_estados->getRegistros();
        
        $db['campos']   = array(
            array('select',   'id_animal',  'animal', $db['animales'], 'required'),
            array('select',   'id_estado',  'estado', $db['estados'], 'required'),
            array('titulo', '', 'required'),
            array('comentario', '', ''),
        );
        
        $this->armarAbm($id, $db);                     // Envia todo a la plantilla de la pagina
    }
}
?>