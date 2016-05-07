<?php 
class m_alertas extends MY_Model {
		
	protected $_tablename	= 'alertas';
	protected $_id_table	= 'id_alerta';
	protected $_order		= 'alerta';
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
 			Trae las alertas para un ente o usuario
 --------------------------------------------------------------------------------*/				

	function getAlertas($id_usuario, $id_ente = NULL){
		$sql = 
		"SELECT
			*
		FROM
			$this->_tablename
		WHERE
			$this->_tablename.visto = 0 AND ";
		
		if($id_ente == NULL) {
			$sql .=
			"$this->_tablename.id_usuario = '$id_usuario'";
		}else{
			$sql .=
			"$this->_tablename.id_usuario = '$id_usuario' AND
			 $this->_tablename.id_ente = '$id_ente'";
		}
			
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0){
			foreach ($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}	
	}
	
/*--------------------------------------------------------------------------------	
 			Cambia el estado de las alertas a vistas
 --------------------------------------------------------------------------------*/				
	
	function setVistas($id_usuario, $id_ente = NULL){
		$date_upd = date('Y-m-d H:i:s');
		$session_data = $this->session->userdata('logged_in');	
		
		$sql = 
		"UPDATE
			$this->_tablename
		SET
			$this->_tablename.visto 	= 1,
			$this->_tablename.date_upd	= '$date_upd',
			$this->_tablename.user_upd	= '$id_usuario'
		WHERE ";
		
		if($id_ente == NULL){
			$sql .= 
			"$this->_tablename.id_usuario = '$id_usuario'";
		} else {
			$sql .= 
			"$this->_tablename.id_usuario = '$id_usuario' AND 
			 $this->_tablename.id_ente	= '$id_ente' ";
		}
			
		$this->db->query($sql);
	}
} 
?>