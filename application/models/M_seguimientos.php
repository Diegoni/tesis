<?php 
class m_seguimientos extends MY_Model 
{		
	protected $_tablename	= 'seguimientos';
	protected $_id_table	= 'id_seguimiento';
	protected $_order		= 'id_seguimiento';
	protected $_relation    =  array(
        'id_estado' => array(
            'table'     => 'seguimientos_estados',
            'subjet'    => 'estado'
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