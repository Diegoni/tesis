<?php 
class m_formas_pagos extends MY_Model 
{		
	protected $_tablename	= 'formas_pagos';
	protected $_id_table	= 'id_forma_pago';
	protected $_order		= 'forma_pago';
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