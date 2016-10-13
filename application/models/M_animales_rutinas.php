<?php 
class m_animales_rutinas extends MY_Model 
{		
	protected $_tablename	= 'animales_rutinas';
	protected $_id_table	= 'id_rutina';
	protected $_order		= 'id_rutina';
	protected $_relation    =  array(   
        'id_tipo' => array(
            'table'     => 'animales_tipos',
            'subjet'    => 'tipo'
        ),
        'id_sector' => array(
            'table'     => 'tambos_sectores',
            'subjet'    => 'sector'
        ),
         '  id_dia' => array(
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