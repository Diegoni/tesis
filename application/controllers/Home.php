<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends My_Controller 
{
	protected $_subject = 'home';
    protected $_model   = '';
	
	function __construct(){
		parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model
		);
	} 


/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Pantalla de inicio: pantalla de inicio y redireccion 
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   	

	
	public function index()
	{	
		$this->armarVista('inicio');
	}
}
