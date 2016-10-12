<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pagos extends MY_Controller 
{
	protected $_subject = 'pagos';
    protected $_model   = 'm_pagos';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
        $this->load->model('m_facturas');
        $this->load->model('m_formas_pagos');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {                           
        $db['facturas']        = $this->m_facturas->getRegistros();
        $db['formas']          = $this->m_formas_pagos->getRegistros();

        $db['campos']   = array(
            array('select',   'id_factura',  'id_factura', $db['facturas']),
            array('select',   'id_forma_pago',  'forma_pago', $db['formas']),
            array('total',   'onlyFloat',  'required'),
            array('comentario',   '',  ''),
        );
        
        $this->armarAbm($id, $db);
    }
}
?>