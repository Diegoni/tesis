<?php
include_once('My_model.php');

class m_tambos_caminos extends My_Model
{
	protected $_tablename	= 'tambos_caminos';
	protected $_id_table	= 'id_camino';
	protected $_name		= 'camino';
	protected $_order		= 'id_camino';
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
}