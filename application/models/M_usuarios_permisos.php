<?php 
class m_usuarios_permisos extends MY_Model 
{		
	protected $_tablename	= 'usuarios_permisos';
	protected $_id_table	= 'id_permiso';
	protected $_order		= 'id_permiso';
	protected $_relation	= array(
        'id_menu' => array(
            'table'     => 'menus',
            'subjet'    => array('menu', 'id_padre'),
        ),
        'id_perfil' => array(
            'table'     => 'usuarios_perfiles',
            'subjet'    => 'perfil'
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
   
    
    function getMenu($id_perfil)
    {
        $sql = "
        SELECT 
            * 
        FROM 
            $this->_tablename 
        INNER JOIN 
            menus ON($this->_tablename.id_menu = menus.id_menu) 
        WHERE 
            ($this->_tablename.id_perfil = '$id_perfil' AND
            $this->_tablename.eliminado = '0')
        ORDER BY
            menus.menu";

        return $this->getQuery($sql);
    }
    
}  
?>