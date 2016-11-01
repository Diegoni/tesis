<?php
class Model
{
    protected $_db;
	protected $db_host = 'localhost';
	protected $db_user = 'root';
	protected $db_pass = '';
	protected $db_name = 'tesis';
	protected $db_char = 'utf-8';
	
	
    public function __construct()
    {
    	$this->_db = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
		if ( $this->_db->connect_errno )
        {
            echo "Fallo al conectar a MySQL: ". $this->_db->connect_error;
            return;    
        }
		
		$this->_db->set_charset($this->db_char);
    }
}