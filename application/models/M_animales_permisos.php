<?php 
class m_animales_permisos extends MY_Model 
{		
	protected $_tablename	= 'animales_permisos';
	protected $_id_table	= 'id_permiso';
	protected $_order		= 'id_permiso';
	protected $_relation    =  array(   
        'id_sector' => array(
            'table'     => 'tambos_sectores',
            'subjet'    => 'sector'
        ),
        'id_animal' => array(
            'table'     => 'animales',
            'subjet'    => 'animal'
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