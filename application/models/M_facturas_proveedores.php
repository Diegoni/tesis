<?php 
class m_facturas_proveedores extends MY_Model 
{		
	protected $_tablename	= 'facturas_proveedores';
	protected $_id_table	= 'id_factura';
	protected $_order		= 'id_factura';
	protected $_relation    =  array(
        'id_proveedor' => array(
            'table'     => 'proveedores',
            'subjet'    => 'proveedor'
        ),
        'id_condicion_pago' => array(
            'table'     => 'condiciones_pagos',
            'subjet'    => 'condicion_pago'
        ),
        'id_origen' => array(
            'table'     => 'origenes',
            'subjet'    => 'origen'
        ),
        'id_envio' => array(
            'table'     => 'envios',
            'subjet'    => 'envio'
        ),
        'id_estado' => array(
            'table'     => 'facturas_estados',
            'subjet'    => 'estado'
        ),
    );
    
    
    
    function __construct()
	{
		parent::__construct(
			$tablename		= $this->_tablename, 
			$id_table		= $this->_id_table, 
			$order			= $this->_order,
			$relation		= $this->_relation
		);
	}
} 
?>