<?php 
class m_envios extends MY_Model 
{		
	protected $_tablename	= 'envios';
	protected $_id_table	= 'id_envio';
	protected $_order		= 'envio';
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