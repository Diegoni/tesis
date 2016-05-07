<?php 
class m_localidades extends MY_Model {
		
	protected $_tablename	= 'localidades';
	protected $_id_table	= 'id_localidad';
	protected $_order		= 'localidad';
	protected $_relation	= array(
		'id_provincia' => array(
			'table'		=> 'provincias',
			'subjet'	=> 'provincia'
		)		
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
 			Obtiene el id de la localidad para un texto 
 --------------------------------------------------------------------------------*/		
	
	function getID($text, $id_provincia){
		$sql = 
		"SELECT 
			$this->_id_table
		FROM 
			$this->_tablename
		WHERE 
			$this->_tablename.localidad LIKE '%$text%' AND
			$this->_tablename.id_provincia = '$id_provincia'";
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0){
			foreach ($query->result() as $fila){
				$id = $fila->id_localidad;
			}	
			
			return $id;
		} else {
			return $text;
		}
	}
} 
?>
