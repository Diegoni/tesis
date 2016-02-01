<?php
class MY_Controller extends Ci_Controller{
	protected $_subject;
	
    public function __construct($subjet){
    	$this->_subject		= $subjet;
		
        parent::__construct();
    }
	
	function armar_vista($vista){
		$db['subjet'] = ucwords($this->_subject);
		
		$this->load->view('plantilla/head', $db);
		$this->load->view('plantilla/menu-top');
		$this->load->view('plantilla/menu-left');
		$this->load->view($this->_subject.'/'.$vista);
		$this->load->view('plantilla/footer');
	}
	
}