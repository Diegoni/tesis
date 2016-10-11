<?php 
class m_dias extends MY_Model 
{		
	protected $_tablename	= 'dias';
	protected $_id_table	= 'id_dia';
	protected $_order		= 'id_dia';
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