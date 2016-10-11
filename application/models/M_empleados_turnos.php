<?php 
class m_empleados_turnos extends MY_Model 
{		
	protected $_tablename	= 'empleados_turnos';
	protected $_id_table	= 'id_turno';
	protected $_order		= 'id_turno';
	protected $_relation    =  array(
        'id_puesto' => array(
            'table'     => 'empleados_puestos',
            'subjet'    => 'puesto'
        ),
        'id_sector' => array(
            'table'     => 'tambos_sectores',
            'subjet'    => 'sector'
        ),
        'id_dia' => array(
            'table'     => 'dias',
            'subjet'    => 'dia'
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