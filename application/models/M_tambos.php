<?php 
class m_tambos extends MY_Model 
{		
	protected $_tablename	= 'tambos';
	protected $_id_table	= 'id_tambos';
	protected $_order		= 'tambo';
	protected $_relation    =  array(
        'id_encargado' => array(
            'table'     => 'empleados',
            'subjet'    => 'apellidos'
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