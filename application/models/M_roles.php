<?php 
class m_roles extends MY_Model 
{		
	protected $_tablename	= 'roles';
	protected $_id_table	= 'id_rol';
	protected $_order		= 'id_rol';
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