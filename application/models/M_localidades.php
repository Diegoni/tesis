<?php 
class m_localidades extends MY_Model 
{		
	protected $_tablename	= 'localidades';
	protected $_id_table	= 'id_localidad';
	protected $_order		= 'localidad';
	protected $_relation    =  array(
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