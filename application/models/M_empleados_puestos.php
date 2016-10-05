<?php 
class m_empleados_puestos extends MY_Model 
{		
	protected $_tablename	= 'empleados_puestos';
	protected $_id_table	= 'id_puesto';
	protected $_order		= 'id_puesto';
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