<?php 
class m_transacciones extends MY_Model 
{		
	protected $_tablename	= 'transacciones';
	protected $_id_table	= 'id_transaccion';
	protected $_order		= 'id_transaccion';
	protected $_relation    =  array(
        'id_estado' => array(
            'table'     => 'transacciones_estados',
            'subjet'    => 'estado'
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
    
    
    function getTransacciones($inicio, $final){
        $inicio = date('Y-m-d', strtotime($inicio));
        $final = date('Y-m-d', strtotime($final));
        
        $sql = "
        SELECT 
            $this->_tablename.*, 
            transacciones_estados.estado,
            usuarios.usuario as usuario 
        FROM  
            $this->_tablename
        INNER JOIN             
            transacciones_estados ON($this->_tablename.id_estado = transacciones_estados.id_estado)
        LEFT JOIN            
            usuarios ON($this->_tablename.user_upd = usuarios.id_usuario)
        WHERE
            `date_add` >  '$inicio 00:00:00' AND          
            `date_add` <  '$final 00:00:00'";

        return $this->getQuery($sql);
    }    
} 
?>