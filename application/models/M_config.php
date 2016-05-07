<?php 
class m_config extends MY_Model {
		
	protected $_tablename	= 'config';
	protected $_id_table	= 'id_config';
	protected $_order		= 'id_config';
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
 			Trae la configuración del sitio y lo combierte en array
 --------------------------------------------------------------------------------*/		
	
	function getConfig(){
		$sql = 
		"SELECT
			*
		FROM
			$this->_tablename
		WHERE
			$this->_tablename.$this->_id_table = 1";
		
		$this->db->cache_on();
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0){
			foreach ($query->result() as $row){
				$config = (array) $row;
			}
			
			foreach ($config as $key => $value) {
				$this->config->set_item($key, $value);
			}
			
			return $config;
		} else {
			return FALSE; 
		}
	}
} 
?>
