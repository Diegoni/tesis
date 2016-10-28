<?php 
class m_tambos_lectores extends MY_Model 
{		
	protected $_tablename	= 'tambos_lectores';
	protected $_id_table	= 'id_lector';
	protected $_order		= 'lector';
	protected $_relation    =  array(
        'id_proveedor' => array(
            'table'     => 'proveedores',
            'subjet'    => 'proveedor'
        ),
		'id_compuerta' => array(
            'table'     => 'tambos_compuertas',
            'subjet'    => 'compuerta'
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