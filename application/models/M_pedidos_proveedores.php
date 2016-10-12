<?php 
class m_pedidos_proveedores extends MY_Model 
{		
	protected $_tablename	= 'pedidos_proveedores';
	protected $_id_table	= 'id_pedido';
	protected $_order		= 'id_pedido';
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
            'table'     => 'pedidos_estados',
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