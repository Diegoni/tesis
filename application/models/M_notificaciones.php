<?php 
class m_notificaciones extends MY_Model {
		
	protected $_tablename	= 'notificaciones';
	protected $_id_table	= 'id_notificacion';
	protected $_order		= 'id_notificacion';
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