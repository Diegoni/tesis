<?php 
class m_tambos_sectores extends MY_Model 
{		
	protected $_tablename	= 'tambos_sectores';
	protected $_id_table	= 'id_sector';
	protected $_order		= 'sector';
	protected $_relation    =  array(
        'id_empleado' => array(
            'table'     => 'empleados',
            'subjet'    => 'empleado'
        ),
        'id_tambo' => array(
            'table'     => 'tambos',
            'subjet'    => 'tambo'
        ),
        'id_tipo' => array(
            'table'     => 'tambos_sectores_tipos',
            'subjet'    => 'tipo'
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