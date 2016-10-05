<?php 
class m_seguimientos_estados extends MY_Model 
{		
	protected $_tablename	= 'seguimientos_estados';
	protected $_id_table	= 'id_estado';
	protected $_order		= 'id_estado';
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