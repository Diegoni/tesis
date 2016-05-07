<?php 
class m_convenios extends MY_Model {
		
	protected $_tablename	= 'convenios';
	protected $_id_table	= 'id_convenio';
	protected $_order		= 'cod_convenio';
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
