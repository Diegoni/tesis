<?php 
class m_leyendas extends MY_Model {
		
	protected $_tablename	= 'leyendas';
	protected $_id_table	= 'id_leyenda';
	protected $_order		= 'leyenda';
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
