<?php 
class m_tambos_caminos extends MY_Model 
{		
	protected $_tablename	= 'tambos_caminos';        
	protected $_id_table	= 'id_camino';     
	protected $_order		= 'camino';        
	protected $_relation    =  array();
		
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
            
       Devuelve el camino
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/ 
	
	
	function getCamino($inicio, $final)
    {
        $sql = "
        SELECT 
            * 
        FROM 
            tambos_caminos 
        WHERE
            tambos_caminos.inicio = '$inicio' AND
            tambos_caminos.final = '$final'";
            
        $query = $this->db->query($sql);
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $fila)
			{
				$caminos[] = $fila;
			}	
			
			return $caminos;	
        }
        else
        {
            return FALSE;   
        }
    }
} 
?>