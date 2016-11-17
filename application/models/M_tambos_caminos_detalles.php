<?php 
class m_tambos_caminos_detalles extends MY_Model 
{		
	protected $_tablename	= 'tambos_caminos_detalles';
	protected $_id_table	= 'id_detalle';
	protected $_order		= 'id_camino';
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