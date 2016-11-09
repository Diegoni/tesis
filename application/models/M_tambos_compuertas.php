<?php 
class m_tambos_compuertas extends MY_Model 
{		
	protected $_tablename	= 'tambos_compuertas';
	protected $_id_table	= 'id_compuerta';
	protected $_order		= 'compuerta';
	protected $_relation    =  array(
        'id_proveedor' => array(
            'table'     => 'proveedores',
            'subjet'    => 'proveedor'
        ),
        'id_sector' => array(
            'table'     => 'tambos_sectores',
            'subjet'    => 'sector'
        ),
    );
		
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