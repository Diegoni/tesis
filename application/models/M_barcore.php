<?php 
class m_barcore extends MY_Model {
		
	protected $_tablename	= 'barcore';
	protected $_id_table	= 'id_barcore';
	protected $_order		= 'id_barcore';
	protected $_relation	= array(
		'id_formato' => array(
			'table'		=> 'barcore_formatos',
			'subjet'	=> 'formato'
		),
		'id_tipo' => array(
			'table'		=> 'barcore_tipos',
			'subjet'	=> 'tipo'
		),
		
	);
		
	function __construct(){
		parent::__construct(
			$tablename		= $this->_tablename, 
			$id_table		= $this->_id_table, 
			$order			= $this->_order,
			$relation		= $this->_relation
		);
	}
} 
?>