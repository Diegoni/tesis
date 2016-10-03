<?php 
class m_roles_permisos extends MY_Model 
{		
	protected $_tablename	= 'roles_permisos';
	protected $_id_table	= 'id_rol_permiso';
	protected $_order		= 'id_rol_permiso';
	protected $_relation	= array(
        'id_permiso' => array(
            'table'     => 'permisos',
            'subjet'    => array('menu', 'id_padre'),
        ),
        'id_rol' => array(
            'table'     => 'roles',
            'subjet'    => 'rol'
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
            
       Comprueba si usuario y pass coinciden
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/ 
   
    
    function getMenu($id_rol)
    {
        $sql = "
        SELECT 
            * 
        FROM 
            $this->_tablename 
        INNER JOIN 
            permisos ON($this->_tablename.id_permiso = permisos.id_permiso) 
        WHERE 
            ($this->_tablename.id_rol = '$id_rol' AND
            $this->_tablename.eliminado = '0')";
            
        return $this->getQuery($sql);
    }
    
}  
?>