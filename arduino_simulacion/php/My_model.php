<?php
include_once('Model.php');
class MY_Model extends Model
{
	protected $_tablename	= '';
	protected $_id			= '';
	protected $_order		= '';
	protected $_name		= '';
	protected $_data_model	= array();
	function __construct(
				$tablename	= null, 
				$id			= null,
				$name		= null,
				$order		= null,
				$data_model	= null 
				)
	{
		$this->_tablename	= $tablename;
		$this->_id			= $id;
		$this->_order		= $order;
		$this->_name		= $name;
		$this->_data_model	= $data_model;
		parent::__construct();
	}
	
	public function get_registros($where = NULL)
    {
    	if($where == NULL)
		{
			$consulta = 'SELECT * FROM '.$this->_tablename.' ORDER BY '.$this->_order;	
		}
		else
		{
			$consulta = 'SELECT * FROM '.$this->_tablename.' WHERE '.$where.' ORDER BY '.$this->_order;
		}
		
		$result = $this->_db->query($consulta);
		
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
	
		
	function insert($data)
	{
		$result = $this->_db->query('SELECT * FROM '.$this->_tablename.' LIMIT 1');
		$finfo	= $result->fetch_fields();
		
		$campos = "(";
		$datos	= " VALUES (";
		foreach ($data as $key => $value) {
			foreach ($finfo as $val) {
				if($key == $val->name){
					$campos .= $key." ,";
					
					if(	$val->type == 252 || //text 
						$val->type == 253 || //varchar
						$val->type == 254 || //char
						$val->type == 10 || //date
						$val->type == 11 || //datetime
						$val->type == 12)	//time
					{
						$datos	.= "'".$value."' ,";	
					}
					else
					{
						$datos	.= $value." ,";	
					}
				}
			}
		}
		
		//agregamos fecha de alta
		foreach ($finfo as $val) {
			if($val->name == 'date_add')
			{
				$campos .= "date_add ,";
				$datos	.= "'".date('Y:m:d H:i:s')."' ,";				
			}
		}
		
		//borramos ultima coma de la cadena
		$campos = trim($campos, ",");
		$datos	= trim($datos, ",");
		$campos	.= ")";
		$datos	.= ")";
		
		$query = "INSERT INTO 
					$this->_tablename 
					$campos
					$datos";
		
		$this->_db->query($query);
		
		return $this->_db->insert_id;
	}
	
	function update($data, $id)
	{
		$campos = '';
		$result = $this->_db->query('SELECT * FROM '.$this->_tablename.' LIMIT 1');
		$finfo	= $result->fetch_fields();
		
		foreach ($data as $key => $value) {
			foreach ($finfo as $val) {
				if($key == $val->name){
					if(	$val->type == 252 || //text 
						$val->type == 253 || //varchar
						$val->type == 254 || //char
						$val->type == 10 || //date
						$val->type == 11 || //datetime
						$val->type == 12)	//time
					{
						$campos .= "`".$key."` = '".$value."' ,";
					}
					else
					{
						$campos .= "`".$key."` = ".$value.",";	
					}
				}
			}
		}
		
		$campos	= trim($campos, ",");
		
		$query = "UPDATE 
					$this->_tablename
					SET 
					$campos
					WHERE
					$this->_id = $id";
		
		$this->_db->query($query);
	}
	
	
	function getID()
	{
		return $this->_id;
	}
}