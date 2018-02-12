<?php 
class m_animales_marcaciones extends MY_Model 
{		
	protected $_tablename	= 'animales_marcaciones';
	protected $_id_table	= 'id_marcacion';
	protected $_order		= 'id_marcacion';
	protected $_relation    = array(   
        'id_camino' => array(
            'table'     => 'tambos_caminos',
            'subjet'    => 'camino'
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