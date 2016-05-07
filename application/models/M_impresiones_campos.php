<?php 
class m_impresiones_campos extends MY_Model {
		
	protected $_tablename	= 'impresiones_campos';
	protected $_id_table	= 'id_campo';
	protected $_order		= 'cadena';
	protected $_relation	= '';
		
	function __construct(){
		parent::__construct(
			$tablename		= $this->_tablename, 
			$id_table		= $this->_id_table, 
			$order			= $this->_order,
			$relation		= $this->_relation
		);
	}
} 
?>
