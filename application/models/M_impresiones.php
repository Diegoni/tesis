<?php 
class m_impresiones extends MY_Model {
		
	protected $_tablename	= 'impresiones';
	protected $_id_table	= 'id_impresion';
	protected $_order		= 'id_impresion';
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
