<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Xxx extends MY_Controller 
{
	protected $_subject = 'xxx';                 // Nombre con el que se va a identificar el modulo
    protected $_model   = 'm_xxx';               // Modelo principal, la vista tabla automatica
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model'); // Linea obligatoria  
        $this->load->model('m_otrom');              // Carga de otro modelo necesario
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)                              // Funcion para abm
    {                           
        $db['otrom']    = $this->m_otrom->getRegistros(); // Carga para el select
        
        $db['campos']   = array(
            array('campo',    'restricciones', 'tags'), // cargar un input
            array('select',   'id_campo',  'campo', $db['otromodelo']), // cargar un select
            array('checkbox', 'campo'),                 // cargar un checkbox
        );
        
        $this->armarAbm($id, $db);                     // Envia todo a la plantilla de la pagina
    }
}
?>