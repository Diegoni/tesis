<?php 
class m_clientes extends MY_Model 
{		
	protected $_tablename	= 'clientes';
	protected $_id_table	= 'id_cliente';
	protected $_order		= 'cliente';
	protected $_relation    =  array(
        'id_tipo' => array(
            'table'     => 'clientes_tipos',
            'subjet'    => 'tipo'
        ),
        'id_forma_juridica' => array(
            'table'     => 'formas_juridicas',
            'subjet'    => 'forma_juridica'
        ),
        'id_empleado' => array(
            'table'     => 'empleados',
            'subjet'    => 'empleado'
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