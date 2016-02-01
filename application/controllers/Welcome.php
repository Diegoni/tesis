<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends My_Controller {

	protected $_subject		= 'home';
	
	function __construct(){
		parent::__construct(
				$subjet		= $this->_subject 
		);
		
	} 
	 
	public function index(){
		$this->armar_vista('home');
	}
}
