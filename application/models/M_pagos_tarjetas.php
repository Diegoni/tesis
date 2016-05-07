<?php 
class m_pagos_tarjetas extends MY_Model {
		
	protected $_tablename	= 'pagos_tarjetas';
	protected $_id_table	= 'id_pago';
	protected $_order		= 'id_tarjeta';
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
 			Inserta un pago y controla si el pago no existe
 --------------------------------------------------------------------------------*/			
	
	function insertPago($arreglo){
		$sql =
		"SELECT 
			$this->_tablename.agencia,
			$this->_tablename.terminal,
			$this->_tablename.nro_transaccion
		FROM
			$this->_tablename
		WHERE
			$this->_tablename.agencia 	= $arreglo[agencia] AND
			$this->_tablename.terminal	= $arreglo[terminal] AND
			$this->_tablename.nro_transaccion = $arreglo[nro_transaccion]";
		
		$query = $this->db->query($sql);
		if($query->num_rows() == 0){
			return $this->insert($arreglo);
		}else{
			return 0;
		}
	}
	
/*--------------------------------------------------------------------------------	
 			Busca los pagos generados de un afiliado
 --------------------------------------------------------------------------------*/			
	
	function getPagos($id_afiliado){
		$sql = 
		"SELECT
			$this->_tablename.agencia,
			$this->_tablename.terminal,
			$this->_tablename.nro_transaccion,
			$this->_tablename.fecha_pago,
			$this->_tablename.importe
		FROM
			$this->_tablename
		INNER JOIN 
			tarjetas ON($this->_tablename.id_tarjeta = tarjetas.id_tarjeta)
		WHERE 
			tarjetas.id_afiliado = '$id_afiliado'";
		
		return $this->getQuery($sql);	
	}
} 
?>