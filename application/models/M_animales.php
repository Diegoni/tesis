<?php 
class m_animales extends MY_Model 
{		
	protected $_tablename	= 'animales';
	protected $_id_table	= 'id_animal';
	protected $_order		= 'animal';
	protected $_relation    =  array(   
        'id_tipo' => array(
            'table'     => 'animales_tipos',
            'subjet'    => 'tipo'
        ),
        'id_proveedor' => array(
            'table'     => 'proveedores',
            'subjet'    => 'proveedor'
        ),
         'id_estado' => array(
            'table'     => 'animales_estados',
            'subjet'    => 'estado'
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