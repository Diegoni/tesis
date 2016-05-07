<?php 
class m_archivos extends MY_Model {
		
	protected $_tablename	= 'archivos';
	protected $_id_table	= 'id_archivo';
	protected $_order		= 'date_add';
	protected $_relation	= array(
		'id_usuario' => array(
			'table'		=> 'usuarios',
			'subjet'	=> 'usuario'
		),
		'id_ente' => array(
			'table'		=> 'entes',
			'subjet'	=> 'nombre as ente'
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