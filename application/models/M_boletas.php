<?php 
class m_boletas extends MY_Model {
		
	protected $_tablename	= 'boletas';
	protected $_id_table	= 'id_boleta';
	protected $_order		= 'id_boleta';
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
			'subjet'	=> 'nombre'
		),
		
	);
		
	function __construct(){
		parent::__construct(
			$tablename		= $this->_tablename, 
			$id_table		= $this->_id_table, 
			$order			= $this->_order,
			$subject		= $this->_subject
		);
		
		$this->load->library('codigos/codigo_6100');
	}
	
/*--------------------------------------------------------------------------------	
 			Inserta boleta y genera codigo de barra correspondiente
 --------------------------------------------------------------------------------*/				
	
	function insertBoleta($registro){
		$sql = 
		"SELECT
			codigo_afiliado,
			entes.codigo,
			convenios.cod_convenio
		FROM
			afiliados_entes
		INNER JOIN
			entes ON(afiliados_entes.id_ente = entes.id_ente)
		LEFT JOIN
			convenios ON(entes.id_convenio = convenios.id_convenio)
		WHERE
			afiliados_entes.id_afiliado	= $registro[id_afiliado] AND
			afiliados_entes.id_ente		= $registro[id_ente]";
			
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0){
			foreach ($query->result() as $row){
				$registro['cod_afiliado']	= $row->codigo_afiliado;
				$registro['cod_ente']		= $row->codigo;
				$registro['cod_convenio']	= $row->cod_convenio;
			}

			$array_codigo = array(
				'cod_ente'			=> $registro['cod_ente'],	
				'convenios'			=> $registro['cod_convenio'],	
				'cod_afiliado'		=> $registro['cod_afiliado'],		
				'cuota'				=> $registro['nro_cuota'],	
				'fecha_venc_1'		=> $registro['fecha_venc_1'],			
				'importe_venc_1'	=> $registro['importe_venc_1'],
				'fecha_venc_2'		=> $registro['fecha_venc_2'],			
				'importe_venc_2'	=> $registro['importe_venc_2']
			);
			
			$codigo = new Codigo_6100();
			$registro['codigo_barra'] = $codigo->armar_codigo($array_codigo);
			
			$this->insert($registro);
		} 
	}
	
/*--------------------------------------------------------------------------------	
 			Trae un determinado lote de boletas
 --------------------------------------------------------------------------------*/				
	
	function getLote($id_lote, $id_ente){
		$sql = 
		"SELECT
			$this->_tablename.*,
			afiliados.*,
			afiliados_entes.codigo_afiliado,
			entes.codigo as codigo_ente,
			entes.nombre as ente,
			leyendas.leyenda
		FROM
			$this->_tablename
		INNER JOIN 
			afiliados ON(afiliados.id_afiliado = $this->_tablename.id_afiliado)
		INNER JOIN 
			afiliados_entes ON(afiliados.id_afiliado = afiliados_entes.id_afiliado)
		INNER JOIN 
			entes ON(entes.id_ente = afiliados_entes.id_ente)
		INNER JOIN 
			leyendas ON(leyendas.id_leyenda = entes.id_leyenda)
		WHERE
			$this->_tablename.id_lote = '$id_lote' AND
			$this->_tablename.id_ente = '$id_ente'";
		
		return $this->getQuery($sql);
	}
	
/*--------------------------------------------------------------------------------	
 			Trae todas las boletas para un ente o afiliado, pagas o impagas
 --------------------------------------------------------------------------------*/				
	
	function getBoletas($id_ente, $id_afiliado = NULL, $pagadas = NULL){
		$sql = 
		"SELECT
			$this->_tablename.*,
			afiliados.nombre,
			afiliados_entes.codigo_afiliado
		FROM
			$this->_tablename
		LEFT JOIN 
			afiliados ON(afiliados.id_afiliado = $this->_tablename.id_afiliado)
		LEFT JOIN 
			afiliados_entes ON(afiliados.id_afiliado = afiliados_entes.id_afiliado)
		WHERE";
		
		if($id_afiliado == NULL){
			$sql .= 
			"	$this->_tablename.id_ente		= '$id_ente'";
		}else if($pagadas == NULL){
			$sql .= 
			" 	$this->_tablename.id_ente		= '$id_ente' AND
				$this->_tablename.id_afiliado	= '$id_afiliado'";
		}else if($id_afiliado == 0 && $pagadas != NULL){
			$sql .= 
			"	$this->_tablename.id_ente		= '$id_ente' AND
				$this->_tablename.pago			= 0 ";
		}else{
			$sql .= 
			"	$this->_tablename.id_ente		= '$id_ente' AND
				$this->_tablename.id_afiliado	= '$id_afiliado' AND
				$this->_tablename.pago			= 0 ";
		}
		
		return $this->getQuery($sql);
	}
	
/*--------------------------------------------------------------------------------	
 			Trae una boleta con todos sus datos relacionados
 --------------------------------------------------------------------------------*/				
	
	function getBoleta($id_boleta){
		$sql = 
		"SELECT
			$this->_tablename.id_boleta,
			$this->_tablename.cod_afiliado,
			$this->_tablename.fecha_venc_1,
			$this->_tablename.importe_venc_1,
			$this->_tablename.fecha_venc_2,
			$this->_tablename.importe_venc_2,
			$this->_tablename.date_add,
			$this->_tablename.pago,
			$this->_tablename.codigo_barra,
			$this->_tablename.id_lote,
			afiliados.nombre,
			afiliados.apellido,
			afiliados.id_afiliado,
			lotes.nombre as nombre_lote,
			usuarios.usuario,
			afiliados_entes.codigo_afiliado,
			entes.codigo as codigo_ente,
			entes.nombre as ente,
			leyendas.leyenda
		FROM
			$this->_tablename
		INNER JOIN 
			afiliados ON(afiliados.id_afiliado = $this->_tablename.id_afiliado)
		INNER JOIN 
			afiliados_entes ON(afiliados.id_afiliado = afiliados_entes.id_afiliado)
		INNER JOIN 
			entes ON(entes.id_ente = afiliados_entes.id_ente)
		INNER JOIN 
			usuarios ON(usuarios.id_usuario = $this->_tablename.user_add)
		INNER JOIN 
			lotes ON(lotes.id_lote = $this->_tablename.id_lote)
		INNER JOIN 
			leyendas ON(leyendas.id_leyenda = entes.id_leyenda)
		WHERE
			$this->_tablename.id_boleta = '$id_boleta'";
		
		return $this->getQuery($sql);
	}
	
/*--------------------------------------------------------------------------------	
 			Controla codigo de la boleta
 --------------------------------------------------------------------------------*/				
	
	function getCodigo($codigo, $id_ente){ // Redifinir nombre de la funcion 
		$sql = 
		"SELECT
			id_boleta, 
			pago,
			fecha_venc_1,
			importe_venc_1,
			fecha_venc_2,
			importe_venc_2
		FROM
			$this->_tablename
		WHERE
			$this->_tablename.codigo_barra = '$codigo' AND
			$this->_tablename.id_ente = '$id_ente'";
			
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0){
			foreach ($query->result() as $row){
				$return = array(
					'id_boleta'		=> $row->id_boleta,
					'pago'			=> $row->pago,
					'fecha_venc_1'	=> $row->fecha_venc_1,
					'importe_venc_1'=> $row->importe_venc_1,
					'fecha_venc_2'	=> $row->fecha_venc_2,
					'importe_venc_2'=> $row->importe_venc_2,
				);
			}
		}else{
			$return = array(
				'id_boleta'	=> 0,
				'pago'		=> 0
			);
		}
		
		return $return;
	}
	
/*--------------------------------------------------------------------------------	
 			Controla si la boleta no esta duplicada
 --------------------------------------------------------------------------------*/				
	
	function control_generadas($registro){
		$sql =
		"SELECT 
			id_boleta
		FROM 
			$this->_tablename
		WHERE 
			id_afiliado		= '$registro[id_afiliado]' AND
			id_ente			= '$registro[id_ente]' AND
			CAST(importe_venc_1 AS DECIMAL) = CAST('$registro[importe_venc_1]' AS DECIMAL) AND
			CAST(importe_venc_2 AS DECIMAL) = CAST('$registro[importe_venc_2]' AS DECIMAL) AND
			fecha_venc_1	= '$registro[fecha_venc_1]' AND
			fecha_venc_2	= '$registro[fecha_venc_2]' ";
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0){
			foreach ($query->result() as $row){
				$id_boleta = $row->id_boleta;
			}
		} else {
			$id_boleta = 0;
		}
		
		return $id_boleta;
	}
} 
?>
