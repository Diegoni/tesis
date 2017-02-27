<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facturas_proveedores extends MY_Controller 
{
	protected $_subject = 'facturas_proveedores';
    protected $_model   = 'm_facturas_proveedores';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
        $this->load->model('m_proveedores');
        $this->load->model('m_pedidos_proveedores');
        $this->load->model('m_condiciones_pagos');
        $this->load->model('m_formas_pagos');
        $this->load->model('m_origenes');
        $this->load->model('m_envios');
        $this->load->model('m_facturas_estados');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {                           
        $db['proveedores']      = $this->m_proveedores->getRegistros();
        $db['pedidos']          = $this->m_pedidos_proveedores->getRegistros();
        $db['condiciones']      = $this->m_condiciones_pagos->getRegistros();
        $db['formas']           = $this->m_formas_pagos->getRegistros();
        $db['origenes']         = $this->m_origenes->getRegistros();
        $db['envios']           = $this->m_envios->getRegistros();
        $db['estados']          = $this->m_facturas_estados->getRegistros();
        
        $db['campos']   = array(
            array('select',   'id_proveedor',  'proveedor', $db['proveedores']),
            array('select',   'id_pedido',   array('nro_proveedor', 'proveedor'), $db['pedidos']),
            array('nro_factura',   '',  'required'),
            array('fecha_entrega',   '',  ''),
            array('select',   'id_condicion_pago',  'condicion_pago', $db['condiciones']),
            array('select',   'id_forma_pago',  'forma_pago', $db['formas']),
            array('select',   'id_origen',  'origen', $db['origenes']),
            array('select',   'id_envio',  'envio', $db['envios']),
            array('comentario',   '',  ''),  
        );
        
        $this->armarAbm($id, $db);
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