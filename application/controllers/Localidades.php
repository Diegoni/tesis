<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Localidades extends MY_Controller 
{
	protected $_subject = 'Localidades';
    protected $_model   = 'm_localidades';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
        $this->load->model('m_provincias');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {
        $db['provincias'] = $this->m_provincias->getRegistros();
                                   
        $db['campos']   = array(
            array('localidad',    'onlyChar', 'required'),
            array('select',   'id_provincia',  'provincia', $db['provincias']),
        );
        
        $this->armarAbm($id, $db);
    }
}
?>