<?php 
class m_empleados extends MY_Model 
{		
	protected $_tablename	= 'empleados';
	protected $_id_table	= 'id_empleado';
	protected $_order		= 'empleado';
	protected $_relation    = array(
        'id_puesto' => array(
            'table'     => 'empleados_puestos',
            'subjet'    => 'puesto'
        ),
        'id_localidad' => array(
            'table'     => 'localidades',
            'subjet'    => 'localidad'
        ),
        'id_provincia' => array(
            'table'     => 'provincias',
            'subjet'    => 'provincia'
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