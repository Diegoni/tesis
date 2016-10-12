<?php 
class m_origenes extends MY_Model 
{		
	protected $_tablename	= 'origenes';
	protected $_id_table	= 'id_origen';
	protected $_order		= 'origen';
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