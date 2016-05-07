<?php 
class m_pagos_boletas extends MY_Model {
		
	protected $_tablename	= 'pagos_boletas';
	protected $_id_table	= 'id_pago';
	protected $_order		= 'id_boleta';
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
 			Busca los pagos generados de un afiliado
 --------------------------------------------------------------------------------*/			
	
	function getPagos($dias, $id_afiliado = NULL){
		$session_data = $this->session->userdata('logged_in');
			
		$sql = 
		"SELECT
			$this->_tablename.agencia,
			$this->_tablename.terminal,
			$this->_tablename.nro_transaccion,
			$this->_tablename.fechapago,
			$this->_tablename.importe
		FROM
			$this->_tablename
		INNER JOIN 
			boletas ON($this->_tablename.id_boleta = boletas.id_boleta)
		WHERE 
			$this->_tablename.fechapago >= DATE_ADD(CURDATE(), INTERVAL $dias DAY)";
		
		if($id_afiliado != NULL){
			$sql .= "AND boletas.id_afiliado = '$id_afiliado'";
		}else{
			$sql .= "AND boletas.id_ente = '$session_data[id_ente]'";
		}
		
		return $this->getQuery($sql);	
	}
} 
?>