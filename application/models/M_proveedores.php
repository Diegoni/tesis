<?php 
class m_proveedores extends MY_Model 
{		
	protected $_tablename	= 'proveedores';
	protected $_id_table	= 'id_proveedor';
	protected $_order		= 'id_proveedor';
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