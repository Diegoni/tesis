<?php 
class m_barcore_formatos extends MY_Model {
		
	protected $_tablename	= 'barcore_formatos';
	protected $_id_table	= 'id_formato';
	protected $_order		= 'formato';
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