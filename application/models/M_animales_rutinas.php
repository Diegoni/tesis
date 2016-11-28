<?php 
class m_animales_rutinas extends MY_Model 
{		
	protected $_tablename	= 'animales_rutinas';
	protected $_id_table	= 'id_rutina';
	protected $_order		= 'id_rutina';
	protected $_relation    =  array(   
        'id_tipo' => array(
            'table'     => 'animales_tipos',
            'subjet'    => 'tipo'
        ),
        'id_sector' => array(
            'table'     => 'tambos_sectores',
            'subjet'    => 'sector'
        ),
         '  id_dia' => array(
            'table'     => 'dias',
            'subjet'    => 'dia'
        ),
    );
		
	function __construct()
	{
		parent::__construct(
			$tablename		= $this->_tablename, 
			$id_table		= $this->_id_table, 
			$order			= $this->_order,
			$relation		= $this->_relation
		);
	}
	
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Devuelve el sector
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
	
	function getSector($datos)
	{
		$sql = "
		SELECT 
			animales_rutinas.id_sector 
		FROM 
			animales_rutinas 
		INNER JOIN 
			animales_tipos ON(animales_rutinas.id_tipo = animales_tipos.id_tipo)
		INNER JOIN 
			animales ON(animales.id_tipo = animales_tipos.id_tipo)";
			
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $fila)
			{
				$sectores[] = $fila;
			}	
			
			foreach ($sectores as $sector) 
			{
				$id_sector = $sector->id_sector;
			}
			
			return $id_sector;	
		}
		else
		{
			return FALSE;	
		}
	}
} 
?>