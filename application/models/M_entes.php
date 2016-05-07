<?php 
class m_entes extends MY_Model {
		
	protected $_tablename	= 'entes';
	protected $_id_table	= 'id_ente';
	protected $_order		= 'nombre';
	protected $_relation	= array(
		'id_leyenda' => array(
			'table'		=> 'leyendas',
			'subjet'	=> array('leyenda', 'letra_leyenda')
		),
		'id_convenio' => array(
			'table'		=> 'convenios',
			'subjet'	=> 'cod_convenio'
		),
		'id_impresion' => array(
			'table'		=> 'impresiones',
			'subjet'	=> 'impresion'
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
 			Inserta un ente y controla si el codigo no existe
 --------------------------------------------------------------------------------*/			
	
	function insertEntes($arreglo){
		$sql = 
		"SELECT
			codigo
		FROM
			$this->_tablename
		WHERE 
			$this->_tablename.codigo = $arreglo[codigo]";
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() == 0){
			$arreglo = $this->getExtraField($arreglo);		
		
			$this->db->insert($this->_tablename, $arreglo);
			
			$id_insert	= $this->db->insert_id();
					
			return $id_insert;	
		}else{
			return FALSE;
		}
	}
	
/*--------------------------------------------------------------------------------	
 			Trae todos los entes para un determinado usuario
 --------------------------------------------------------------------------------*/		
	
	function getEntes($id_usuario){
		$sql = 
		"SELECT
			*
		FROM
			$this->_tablename
		INNER JOIN 
			entes_usuarios ON(entes_usuarios.id_ente = $this->_tablename.$this->_id_table)
		WHERE
			entes_usuarios.id_usuario = '$id_usuario' AND
			$this->_tablename.eliminado = '0'";
			
		return $this->getQuery($sql);
	}
	
/*--------------------------------------------------------------------------------	
 			Controla si el codigo dle ente existe
 --------------------------------------------------------------------------------*/		
	
	function controlCodigo($codigo, $id_ente){
		$sql = 
		"SELECT
			*
		FROM
			$this->_tablename
		WHERE
			$this->_tablename.codigo = '$codigo' AND
			$this->_tablename.$this->_id_table != '$id_ente'";
			
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0){
			return 0;
		} else {
			return 1;
		}
	}
	
/*--------------------------------------------------------------------------------	
 			Cargamos extra field en entes
 --------------------------------------------------------------------------------*/		
	
	function extraField($registro){	
		$this->db->where('codigo', $registro['codigo']);
		$this->db->update($this->_tablename, $registro);
	}
} 
?>
