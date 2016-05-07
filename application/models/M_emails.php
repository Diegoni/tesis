<?php 
class m_emails extends MY_Model {
		
	protected $_tablename	= 'emails';
	protected $_id_table	= 'id_email';
	protected $_order		= 'id_email';
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