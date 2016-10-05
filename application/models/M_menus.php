<?php 
class m_menus extends MY_Model 
{		
	protected $_tablename	= 'menus';
	protected $_id_table	= 'id_menu';
	protected $_order		= 'id_menu';
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