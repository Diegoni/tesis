<?php 
class MY_Model extends CI_Model 
{
	protected $_tablename	= '';
	protected $_id_table	= '';
	protected $_order		= '';
	protected $_relation	= '';
	protected $_subject		= '';
    protected $_debug       = TRUE;
	
	function __construct(
		$tablename	= null, 
		$id			= null,
		$order		= null,
		$relation	= null
	)
	{
		$this->_tablename	= $tablename;
		$this->_id_table	= $id;
		$this->_order		= $order;
		$this->_relation	= $relation;
		$this->_subject		= $tablename;
		
		parent::__construct();
	}


/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Función para traer todos los registros o filtrados
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/

	
	function getRegistros($id = NULL, $campo = NULL)
	{
		$sql = $this->getSelect();
		// SI no existe el campo eliminado lo creamos
		if(!$this->db->field_exists('eliminado', $this->_tablename))
		{
			$add = "ALTER TABLE $this->_tablename ADD `eliminado` TINYINT NOT NULL";
			$this->db->query($add);
		}
		// No viene el campo id, trae todos los registros que no esten eliminados
		if($id != NULL)
		{
		    // No viene la variable campo, busca por id
			if($campo == NULL)
			{
			    // Solo viene el id, busca por id de la tabla
			    if(!is_array($id))
			    {
                    $sql .= " WHERE $this->_tablename.$this->_id_table = '$id' ";
                // Viene un array de datos donde el key es el campo y el value es el valor buscado    
			    }else
			    {
			        $sql .= " WHERE ";
                    foreach ($id as $_campo => $_valor) 
                    {
                        $sql .= " $_campo = '$_valor' AND";
                    } 
                    $sql = substr($sql, 0, -3);
			    }
				
			}else
			{
				$sql .= " WHERE $this->_tablename.$campo = '$id' ";
			}	
			
			if($id != 'all')
			{
                $sql .= " AND $this->_tablename.eliminado = 0 ";
            }  
		}else
		{
			$sql .= " WHERE $this->_tablename.eliminado = 0 ";
		}
		
        // Varios campos para ordenar
		if(is_array($this->_order))
		{
			$sql .= "ORDER BY ";
			foreach ($this->_order as $order) 
			{
				$sql .= " $this->_tablename.$order,";
			}
			
			$sql = substr($sql, 0, -1);
        // Un solo campo para ordenar    
		}else if($this->_order != '')
		{
			$sql .= "ORDER BY $this->_tablename.$this->_order";
        // No hay campos para ordenar, ordena or id de la tabla            
		}else
		{
			$sql .= "ORDER BY $this->_tablename.$this->_id_table";
		}
		
		return $this->getQuery($sql);
	}


/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Función para ultimos registros
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/

	
	function getLast($cantidad = NULL, $id = NULL, $campo = NULL)
	{
		if($cantidad == NULL)
		{
			$cantidad = 10;
		}
		
		$sql = $this->getSelect();
		
		if($id != NULL)
		{
			if($campo != NULL)
			{
				$where = " AND $this->_tablename.$campo = '$id'";
			}else
			{
				$where = " AND $this->_tablename.$this->_id_table = '$id'";
			}
		}else
		{
			$where = '';
		}
		
		$sql .= "WHERE $this->_tablename.eliminado = 0";
		$sql .= $where;
		$sql .= 
		"ORDER BY
			$this->_tablename.$this->_id_table DESC
		LIMIT 
			$cantidad";
	
		return $this->getQuery($sql);
	}


/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Función para la cantidad de registros
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/

	
	function getCantidad()
	{
		$sql = $this->getSelect();
		
		$sql .= "WHERE $this->_tablename.eliminado = 0";
					
		$query = $this->db->query($sql);
					
		return $query->num_rows();
	}


/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Función armar SELECT con los inner join a las tablas
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/	

	
	function getSelect()
	{
		$inner = '';
		$items = '';
		
		if($this->_relation != '')
		{
			foreach ($this->_relation as $id_relacion => $relacion) 
			{
				if(is_array($relacion['subjet']))
				{
					foreach ($relacion['subjet'] as $subjet) 
					{
						$items .= "$relacion[table].$subjet, ";
					}
				}else
				{
					$items .= "$relacion[table].$relacion[subjet], ";
				}
				
				$inner .= " LEFT JOIN $relacion[table] ON($this->_tablename.$id_relacion = $relacion[table].$id_relacion)";
			}
		}
		
		$sql = "SELECT ";
		$sql .= $items;
		$sql .=	"$this->_tablename.* FROM ";  
		$sql .=	"$this->_tablename ";
		$sql .= $inner;
		
		return $sql;
	}	


/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Función para traer el maximo valor de una tabla
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/ 

	
	function getMax($campo = NULL, $table = NULL, $where = NULL)
	{
		if($campo == NULL)
		{
			$this->db->select_max($this->_id_table);
		}else if(is_array($campo))
		{
			foreach ($campo as $_campo => $as) 
			{
				$this->db->select_max($_campo, $as);	
			}
		}else
		{
			$this->db->select_max($campo);
		}
		
		if($where != NULL)
		{
			foreach ($where as $key => $value) 
			{
				$this->db->where($key, $value);	
			}
		}
		
		if($table == NULL)
		{
			$query = $this->db->get($this->_tablename);
		}else 
		{
			$query = $this->db->get($table);
		}
		
		
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $fila)
			{
				$data = (array) $fila;
			}
		} else {
			$data = FALSE;
		}	
		
		return $data;
	}
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Función para insertar
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/ 

	
	function insert($arreglo)
	{
		$arreglo = $this->getExtraField($arreglo);		
		
		$this->db->insert($this->_tablename, $arreglo);
		
		$id_insert	= $this->db->insert_id();
        
        if($this->_debug)
        {
            $this->logUsuario($arreglo, 'insert', $id_insert);    
        }
				
		return $id_insert;	
	}
    

/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Función para traer todos los campos de una tabla
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/     

	
	function getFields()
	{
		$fields = $this->db->list_fields($this->_tablename );
				
		return $fields;	
	}


/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Función cambiar a estado de baja
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/ 	

	
	function delete($id)
	{
		$arreglo_campos = array(
			'eliminado'	=> 1
		); 
		
		$arreglo_campos = $this->getExtraField($arreglo_campos, 'update');
		
		$this->db->where($this->_id_table, $id);
		$this->db->update($this->_tablename, $arreglo_campos);
		
        if($this->_debug)
        {
            $this->logUsuario($arreglo_campos, 'delete', $id);    
        }
	}
	            
                                                                                          
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Función cambiar a estado de alta
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/                                                                                           


	function restore($id)
	{
		$arreglo_campos = array(
			'eliminado'	=> 0
		); 
		
		$arreglo_campos = $this->getExtraField($arreglo_campos, 'update');
		
		$this->db->where($this->_id_table, $id);
		$this->db->update($this->_tablename, $arreglo_campos);
		
        if($this->_debug)
        {
            $this->logUsuario($arreglo_campos, 'restore', $id);    
        }
	}
 
 
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Función para actualizar
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/ 

	
	function update($arreglo_campos, $id)
	{
		$arreglo_campos = $this->getExtraField($arreglo_campos, 'update');
		
        if(is_array($id))
        {
            foreach ($id as $key => $value) 
            {
                $this->db->where($key, $value);
            }
        }else
        {
            $this->db->where($this->_id_table, $id);    
        }
		
		$this->db->update($this->_tablename, $arreglo_campos);
		if($this->_debug){
            if(is_array($id))
            {
                $id_json = json_encode($id);
                       
                $this->logUsuario($arreglo_campos, 'update', $id_json);    
            }else
            {
                $this->logUsuario($arreglo_campos, 'update', $id);
            }
        }
		
		return $id;
	}


/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Función el nombre del id de la tabla
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/ 

	
	function getIdTable()
	{
		return $this->_id_table;
	}


/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Función el nombre de la tabla
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/     

    
    function getTable()
    {
        return $this->_tablename;
    }    
	
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Función para guardar logs
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/ 
	
	
	function logUsuario($arreglo_campos, $action, $id)
	{
		$no_log = array (
			'logs_usuarios',
		);
		
		if(!in_array($this->_tablename, $no_log))
		{
			$session_data		= $this->session->userdata('logged_in');
		
			$arreglo = array(
			    'id_nivel'      => 4,
			    'log'           => json_encode($arreglo_campos),
                'accion'        => $action,
                'tabla'         => $this->_tablename,
                'registro'      => $id,
            	'user_add'	    => $session_data['id_usuario'],
				'date_add'		=> date('Y/m/d H:i:s'),	
				'programa'      => $this->config->item('programa')	
			);
			
			$this->db->insert('logs_usuarios', $arreglo);
		}
	}
		
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Función para armar la query
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/ 	
 
	function getQuery($sql, $type = NULL)
	{
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0)
		{
			if($type === NULL || $type == 'objet')
			{
				foreach ($query->result() as $fila)
				{
					$data[] = $fila;
				}	
			}else if($type == 'array')
			{
				foreach ($query->result_array() as $row)
				{
					$data[] = $row;
				}
			}
			return $data;
		}else 
		{
			return FALSE;
		}
	}	
	
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Función para campos especiales
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/ 	
	
	
	function getExtraField($array, $action = NULL, $tabla = NULL)
	{
		$session_data = $this->session->userdata('logged_in');	
		
		if($tabla === NULL)
		{
			$tabla = $this->_tablename;
		}
		
		if($action === NULL || $action == 'insert')
		{
		   if($session_data['id_usuario'] == NULL )
		   {
		       $id_usuario = 'end_session';
		   }else 
		   {
		       $id_usuario = $session_data['id_usuario'];
		   }
            
			$campos = array (
				'date_add'	=> date('Y-m-d H:i:s'),
				'date_upd'	=> date('Y-m-d H:i:s'),
				'user_add'	=> $id_usuario,
				'user_upd'	=> $id_usuario
			);
		}else
		{
			$campos = array (
				'date_upd'	=> date('Y-m-d H:i:s'),
				'user_upd'	=> $session_data['id_usuario'],
			);
		}
		
		foreach ($campos as $key => $value) 
		{
			if($this->db->field_exists($key, $tabla))
			{
				if(!isset($array[$key]))
				{
					$array[$key] = $value;	
				}
			}
		}
		
		return $array;
	}
} 
?>