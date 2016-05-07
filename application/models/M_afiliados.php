<?php 
class m_afiliados extends MY_Model {
		
	protected $_tablename	= 'afiliados';
	public 	  $_id_table	= 'id_afiliado';
	protected $_order		= 'nombre';
	protected $_relation	= array(
		'id_provincia' => array(
			'table'		=> 'provincias',
			'subjet'	=> 'provincia'
		),
		'id_localidad' => array(
			'table'		=> 'localidades',
			'subjet'	=> 'localidad'
		),
		
	);
		
	function __construct(){
		parent::__construct(
			$tablename		= $this->_tablename, 
			$id_table		= $this->_id_table, 
			$order			= $this->_order,
			$_relation		= $this->_relation
		);
	}
	
/*--------------------------------------------------------------------------------	
 			Insert de afiliado y recilación afiliado_ente
 --------------------------------------------------------------------------------*/		
	
	function insertMasivo($registros, $afiliado_ente, $ente){
		$this->db->insert_batch($this->_tablename, $registros);
		$this->db->insert_batch('afiliados_entes', $afiliado_ente);
		
		$sql = 
		"SELECT 
			$this->_id_table,
			codigo_afiliado
		FROM
			$this->_tablename
		WHERE 
			$this->_tablename.codigo_afiliado != '0' AND 
			$this->_tablename.id_ente = '$ente' ";
		
		$query = $this->db->query($sql);
		if($query->num_rows() > 0){
			$sql = " UPDATE `afiliados_entes` SET `id_afiliado` = CASE ";
			foreach ($query->result() as $row){
				$sql .= 
				" WHEN 
					`codigo_afiliado` = '$row->codigo_afiliado' AND
					`id_ente` = '$ente'
				THEN 
					'$row->id_afiliado' ";
			}
			
			$sql .= " ELSE `id_afiliado` END ";
			$this->db->query($sql);
			
			$registro = array(
				'codigo_afiliado'	=> 0,
				'id_ente'			=> 0,
			);
			$this->db->update($this->_tablename, $registro, "codigo_afiliado != 0");
		}
	}

/*--------------------------------------------------------------------------------	
 			Insert de afiliado y recilación afiliado_ente
 --------------------------------------------------------------------------------*/		
	
	function insertAfiliado($registro, $ente, $codigo){
		$sql = 
		"SELECT 
			*
		FROM
			afiliados_entes
		WHERE 
			afiliados_entes.id_ente			= '$ente' AND
			afiliados_entes.codigo_afiliado = '$codigo'";
		
		$query = $this->db->query($sql);
		 
		
		if($query->num_rows() == 0){
			$id_afiliado = $this->insert($registro);
			
			$afiliado_ente = array(
				'id_afiliado'		=> $id_afiliado,
				'id_ente'			=> $ente,
				'codigo_afiliado'	=> $codigo,
			);
			
			$afiliado = array(
				'codigo_afiliado'	=> $codigo,
				'id_afiliado'		=> $id_afiliado,
				'insert'			=> 1
			);
			
			$this->db->insert('afiliados_entes', $afiliado_ente);
		}else{
			foreach ($query->result() as $row){
				$id_afiliado = $row->id_afiliado;
			}	
			
			$afiliado = array(
				'codigo_afiliado'	=> $codigo,
				'id_afiliado'		=> $id_afiliado,
				'insert'			=> 0
			);
		}
		
		return $afiliado;
	}
	
/*--------------------------------------------------------------------------------	
 			Trae afiliado, afiliado_ente, ente y ente_usuario 
 --------------------------------------------------------------------------------*/				
	
	function getAfiliados($id_ente, $id_usuario = NULL){
		$sql = 
		"SELECT
			entes.nombre as ente,
			afiliados.nombre as nombre,
			afiliados.apellido as apellido,
			afiliados_entes.codigo_afiliado,
			afiliados.id_afiliado
		FROM
			afiliados
		INNER JOIN 
			afiliados_entes ON(afiliados.id_afiliado = afiliados_entes.id_afiliado)
		INNER JOIN 
			entes ON(afiliados_entes.id_ente = entes.id_ente)
		INNER JOIN 
			entes_usuarios ON(entes_usuarios.id_ente = entes.id_ente)
		WHERE 
			afiliados_entes.id_ente		= '$id_ente' AND 
			afiliados.eliminado			= 0 ";
			
		if($id_usuario != NULL){
			$sql .=  " AND entes_usuarios.id_usuario	= '$id_usuario' ";
		}	
		$sql .= 
		"
		GROUP BY 
			afiliados.id_afiliado
		ORDER BY
			afiliados.apellido,
			afiliados.nombre";

		return $this->getQuery($sql);
	}
	
/*--------------------------------------------------------------------------------	
 			Get: afiliado, afiliado_ente
 --------------------------------------------------------------------------------*/				
	
	function getAfiliado($id_afiliado){
		$sql = 
		"SELECT
			afiliados.*,
			afiliados_entes.codigo_afiliado as codigo
		FROM
			afiliados
		INNER JOIN 
			afiliados_entes ON(afiliados.id_afiliado = afiliados_entes.id_afiliado)
		WHERE 
			afiliados.id_afiliado = '$id_afiliado' ";
					
		return $this->getQuery($sql);
	}
	
/*--------------------------------------------------------------------------------	
 			Contrala si el codigo del afiliado ya existe
 --------------------------------------------------------------------------------*/				
	
	function controlCodigo($codigo, $id_ente, $id_afiliado ){
		$sql = 
		"SELECT
			*
		FROM
			afiliados_entes
		WHERE
			afiliados_entes.codigo_afiliado = '$codigo' AND
			afiliados_entes.id_ente			= '$id_ente' AND
			afiliados_entes.id_afiliado		!= '$id_afiliado'";
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0){
			return 0;
		} else {
			return 1;
		}
	}
	
/*--------------------------------------------------------------------------------	
 			Actualiza el codigo del afiliado
 --------------------------------------------------------------------------------*/				
	
	function updateCodigo($codigo, $id_afiliado){
		$sql = 
		"UPDATE 
			afiliados_entes
		SET 
			codigo_afiliado = '$codigo'
		WHERE 
			id_afiliado = '$id_afiliado'";
		
		$this->db->query($sql);
	}
	
/*--------------------------------------------------------------------------------	
 			Contrala si el codigo del afiliado ya existe
 --------------------------------------------------------------------------------*/				
	
	function getCodigos($id_ente){
		$sql = 
		"SELECT
			codigo_afiliado
		FROM
			afiliados_entes
		WHERE
			afiliados_entes.id_ente			= '$id_ente'";
		
		$codigos = $this->getQuery($sql);
		if($codigos){
			foreach ($codigos as $row) {
				$array_codigo[] = $row->codigo_afiliado;
			}
		}else{
			$array_codigo = FALSE;
		}
		
		return $array_codigo;
	}
} 
?>
