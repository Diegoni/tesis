<?php 
class m_formas_juridicas extends MY_Model 
{		
	protected $_tablename	= 'formas_juridicas';
	protected $_id_table	= 'id_forma_juridica';
	protected $_order		= 'forma_juridica';
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