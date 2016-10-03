<?php 
class m_xxx extends MY_Model 
{		
	protected $_tablename	= 'xxx';        // Nombre de la tabla
	protected $_id_table	= 'id_xxx';     // Id de la tabla
	protected $_order		= 'xxx';        // Orden de la tabla
	protected $_relation    =  array(       // Relacion con otras tablas
        'xxx' => array(                     // Campo de relacion
            'table'     => 'xxx',           // Tabla de la relacion
            'subjet'    => 'xxx'            // Campo de la otra tabla de relacion
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