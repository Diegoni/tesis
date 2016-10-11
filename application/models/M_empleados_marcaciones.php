<?php 
class m_empleados_marcaciones extends MY_Model 
{		
	protected $_tablename	= 'empleados_marcaciones';
	protected $_id_table	= 'id_marcacion';
	protected $_order		= 'id_marcacion';
	protected $_relation    =  array(
        'id_empleado' => array(
            'table'     => 'empleados',
            'subjet'    => array('apellidos', 'nombres')
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