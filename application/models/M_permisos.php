<?php 
class m_permisos extends MY_Model {
		
	protected $_tablename	= 'permisos';
	protected $_id_table	= 'id_permiso';
	protected $_order		= 'seccion';
	protected $_relation	= array(
		'id_perfil' => array(
			'table'		=> 'perfiles',
			'subjet'	=> 'perfil'
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
	
/*--------------------------------------------------------------------------------	
 			Consulta los permidos de un usuario para una sección
 --------------------------------------------------------------------------------*/		
	
	function getPermisos($seccion, $id_perfil){
		$sql = 
		"SELECT 
			*
		FROM 
			$this->_tablename
		WHERE
			$this->_tablename.seccion 	= '$seccion' AND
			$this->_tablename.id_perfil = '$id_perfil'";
		
		return $this->getQuery($sql);
	}
} 
?>
