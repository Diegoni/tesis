<?php 
class m_ordenes extends MY_Model 
{		
	protected $_tablename	= 'ordenes';       
	protected $_id_table	= 'id_ordene';     
	protected $_order		= 'id_ordene';     
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