<?php 
class m_usuarios_perfiles extends MY_Model 
{		
	protected $_tablename	= 'usuarios_perfiles';
	protected $_id_table	= 'id_perfil';
	protected $_order		= 'id_perfil';
	protected $_relation    =  '';
		
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