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
    
    
    function getCamino($inicio, $final)
    {
        $sql = "
        SELECT 
            tambos_caminos.id_camino 
        FROM 
            tambos_caminos 
        WHERE
            tambos_caminos.inicio = '$inicio' AND
            tambos_caminos.final = '$final'";
            
        $result = $this->_db->query($sql);
        
        if($result->num_rows > 0)
        {
            while($row = $result->fetch_array())
            {
                $id_camino = $row['id_camino'];
            }
            
            return $id_camino;   
        }
        else
        {
            return FALSE;   
        }
    }
}