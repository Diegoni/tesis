<?php 
class m_pagos_proveedores extends MY_Model 
{		
	protected $_tablename	= 'pagos_proveedores';
	protected $_id_table	= 'id_pago';
	protected $_order		= 'id_pago';
	protected $_relation    =  array(
        'id_forma_pago' => array(
            'table'     => 'formas_pagos',
            'subjet'    => 'forma_pago'
        ),
        'id_factura' => array(
            'table'     => 'facturas_proveedores',
            'subjet'    => 'nro_factura'
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