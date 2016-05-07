<?php 
class m_provincias extends MY_Model {
		
	protected $_tablename	= 'provincias';
	protected $_id_table	= 'id_provincia';
	protected $_order		= 'provincia';
	protected $_relation	= '';
		
	function __construct(){
		parent::__construct(
			$tablename		= $this->_tablename, 
			$id_table		= $this->_id_table, 
			$order			= $this->_order,
			$relation		= $this->_relation
		);
	}
	
/*--------------------------------------------------------------------------------	
 			Devuelve el ID de una provincia para un texto
 --------------------------------------------------------------------------------*/	
	
	function getID($text){
		$sql = 
		"SELECT 
			$this->_id_table
		FROM 
			$this->_tablename
		WHERE 
			$this->_tablename.provincia LIKE '%$text%'";
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0){
			foreach ($query->result() as $fila){
				$id = $fila->id_provincia;
			}	
			
			return $id;
		} else {
			return $text;
		}
	}
} 
?>
