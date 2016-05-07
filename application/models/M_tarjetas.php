<?php 
class m_tarjetas extends MY_Model {
		
	protected $_tablename	= 'tarjetas';
	protected $_id_table	= 'id_tarjeta';
	protected $_order		= 'id_tarjeta';
	protected $_relation	= array(
		'id_afiliado' => array(
			'table'		=> 'afiliados',
			'subjet'	=> array(
				'nombre',
				'apellido'
			),
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
		
		$this->load->library('codigos/codigo_6200');
	}
	
	
/*--------------------------------------------------------------------------------	
 			Inserta tarjeta y genera codigo de barra correspondiente
 --------------------------------------------------------------------------------*/				
	
	function insertTarjeta($registro){
		$sql = 
		"SELECT
			codigo_afiliado,
			entes.codigo
		FROM
			afiliados_entes
		INNER JOIN
			entes ON(afiliados_entes.id_ente = entes.id_ente)
		WHERE
			afiliados_entes.id_afiliado	= $registro[id_afiliado] AND
			afiliados_entes.id_ente		= $registro[id_ente]";
			
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0){
			foreach ($query->result() as $row){
				$registro['cod_afiliado']	= $row->codigo_afiliado;
				$registro['cod_ente']		= $row->codigo;
			}

			$array_codigo = array(
				'cod_ente'			=> $registro['cod_ente'],	
				'cod_afiliado'		=> $registro['cod_afiliado'],
			);

			$codigo = new Codigo_6200();
			$registro['codigo_barra'] = $codigo->armar_codigo($array_codigo);
			
			$registros = $this->getRegistros($registro['codigo_barra'], 'codigo_barra');
			
			if(!$registros){
				$this->insert($registro); 
			
				return $registro['codigo_barra'];	
			}else{
				return FALSE;
			}	
			
		}else{
			return FALSE;
		}
	}
	
/*--------------------------------------------------------------------------------	
 			Trae todas las tarjetas para un ente o afiliado
 --------------------------------------------------------------------------------*/				
	
	function getTarjetas($id_ente, $id_afiliado = NULL){
		$sql = 
		"SELECT
			$this->_tablename.*,
			afiliados.apellido,
			afiliados.nombre
		FROM
			$this->_tablename
		INNER JOIN 
			afiliados ON(afiliados.id_afiliado = $this->_tablename.id_afiliado)
		INNER JOIN 
			afiliados_entes ON(afiliados.id_afiliado = afiliados_entes.id_afiliado)
		WHERE";
		
		if($id_afiliado == NULL){
			$sql .= " afiliados_entes.id_ente		= '$id_ente'";
		}else {
			$sql .= " afiliados_entes.id_ente		= '$id_ente' AND
					$this->_tablename.id_afiliado	= '$id_afiliado'";
		}
		
		return $this->getQuery($sql);
	}
	
/*--------------------------------------------------------------------------------	
 			Trae todas una tarjeta para un ente
 --------------------------------------------------------------------------------*/				
	
	function getTarjeta($codigo_barra, $id_ente){
		$sql = $this->getSelect();
		$sql .= 
		" WHERE 
			$this->_tablename.codigo_barra = '$codigo_barra' AND
			$this->_tablename.id_ente = '$id_ente'";
			
		return $this->getQuery($sql);
	}
} 
?>
