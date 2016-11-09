<?php 
class m_tambos_caminos extends MY_Model 
{		
	protected $_tablename	= 'tambos_caminos';        
	protected $_id_table	= 'id_camino';     
	protected $_order		= 'camino';        
	protected $_relation    =  array();
		
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