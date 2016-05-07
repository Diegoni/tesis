<?php 
class m_lotes extends MY_Model {
		
	protected $_tablename	= 'lotes';
	protected $_id_table	= 'id_lote';
	protected $_order		= array('nombre', 'fecha_venc_1');
	protected $_relation	= array(
		'id_ente' => array(
			'table'		=> 'entes',
			'subjet'	=> 'nombre'
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
 			Trae todos los lotes para un intervalo de fechas
 --------------------------------------------------------------------------------*/		
	
	function getFecha($fecha){
		$hoy = date('Y-m-d');
		$sql = 
		"SELECT 
			*
		FROM 
			$this->_tablename
		WHERE
			fecha_venc_2 < '$fecha' OR
			fecha_venc_1 > '$hoy'
		ORDER BY 
			$this->_tablename.$this->_id_table";
		
		return $this->getQuery($sql);
	}
	
} 
?>