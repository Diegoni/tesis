<?php
include_once('My_model.php');

class m_animales_rutinas extends My_Model
{
	protected $_tablename	= 'animales_rutinas';
	protected $_id_table	= 'id_rutina';
	protected $_name		= 'id_rutina';
	protected $_order		= 'id_rutina';
	protected $_data_model	= array(
		/*
		'nombre'		=> array(),
		'apellido'		=> array(),
		'alias'			=> array(),
		'telefono'		=> array(),
		'email'			=> array(),
		'direccion'		=> array(),
		*/
	);
	
	function __construct()
	{
		parent::__construct(
				$tablename		= $this->_tablename, 
				$id_table		= $this->_id_table, 
				$name			= $this->_name, 
				$order			= $this->_order, 
				$data_model		= $this->_data_model 
		);
	}
	
	
	function getSector($datos)
	{
		$sql = "
		SELECT 
			* 
		FROM 
			animales_rutinas 
		INNER JOIN 
			animales_tipos ON(animales_rutinas.id_tipo = animales_tipos.id_tipo)
		INNER JOIN 
			animales ON(animales.id_tipo = animales_tipos.id_tipo)";
			
		$result = $this->_db->query($sql);
		
		if($result->num_rows > 0)
		{
			while($row = $result->fetch_array())
			{
				$rows[] = $row;
			}
			
			return $rows;	
		}
		else
		{
			return FALSE;	
		}
	}
}