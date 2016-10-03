<?php 
class m_permisos extends MY_Model 
{		
	protected $_tablename	= 'permisos';
	protected $_id_table	= 'id_permiso';
	protected $_order		= 'id_permiso';
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