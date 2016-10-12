<?php 
class m_facturas extends MY_Model 
{		
	protected $_tablename	= 'facturas';
	protected $_id_table	= 'id_pedido';
	protected $_order		= 'id_pedido';
	protected $_relation    =  array(
        'id_cliente' => array(
            'table'     => 'clientes',
            'subjet'    => 'cliente'
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