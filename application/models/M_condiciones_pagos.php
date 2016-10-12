<?php 
class m_condiciones_pagos extends MY_Model 
{		
	protected $_tablename	= 'condiciones_pagos';
	protected $_id_table	= 'id_condicion_pago';
	protected $_order		= 'condicion_pago';
	protected $_relation    =  '';
		
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