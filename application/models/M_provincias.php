<?php 
class m_provincias extends MY_Model 
{		
	protected $_tablename	= 'provincias';
	protected $_id_table	= 'id_provincia';
	protected $_order		= 'provincia';
	protected $_relation    = '';
		
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