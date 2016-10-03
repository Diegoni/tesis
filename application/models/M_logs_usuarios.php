<?php 
class m_logs_usuarios extends MY_Model 
{		
	protected $_tablename	= 'logs_usuarios'; 
	protected $_id_table	= 'id_log';
	protected $_order		= 'id_log';
	protected $_relation    =  array(       
        'id_nivel' => array(                     
            'table'     => 'logs_niveles',           
            'subjet'    => 'nivel'            
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
            
       Funcion para no armar el array
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/ 
    
    
    function insertLog($log)
    {
        $registro = array(
            'log'   => $log,
        );
        
        return $this->insert($registro);
    }


/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Funcion para no armar el array
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/ 
    
    
    function truncate($log)
    {
        $sql = "TRUNCATE TABLE $this->_tablename";
        
        return $this->db->query($sql);
    }
} 
?>