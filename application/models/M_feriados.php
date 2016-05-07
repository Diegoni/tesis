<?php 
class m_feriados extends MY_Model {
		
	protected $_tablename	= 'feriados';
	protected $_id_table	= 'id_feriado';
	protected $_order		= 'fecha';
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
