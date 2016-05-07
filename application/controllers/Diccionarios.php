<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Diccionarios extends My_Controller {
	
	protected $_subject		= 'diccionarios';	
	
	function __construct(){

		parent::__construct(
			$subjet		= $this->_subject
		);
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('grocery_CRUD');
	} 

/*--------------------------------------------------------------------------------	
 			ABM de diccionarios: leyendas
 --------------------------------------------------------------------------------*/	

	public function leyendas(){
		try{
			$crud = new grocery_CRUD();

			$crud->where('leyendas.eliminado = 0');
			$crud->set_table('leyendas');
			$crud->set_subject('Leyendas');
			$crud->required_fields('leyenda', 'letra_leyenda');
			$crud->fields('leyenda', 'letra_leyenda');
			$crud->columns('leyenda', 'letra_leyenda');

			$output = $crud->render();

			$this->armar_vista_crud($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

/*--------------------------------------------------------------------------------	
 			ABM de diccionarios: provincias
 --------------------------------------------------------------------------------*/	
 
	public function provincias(){
		try{
			$crud = new grocery_CRUD();

			$crud->where('provincias.eliminado = 0');
			$crud->set_table('provincias');
			$crud->set_subject('Provincias');
			$crud->required_fields('provincia');
			$crud->fields('provincia');
			$crud->columns('provincia');

			$output = $crud->render();

			$this->armar_vista_crud($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

/*--------------------------------------------------------------------------------	
 			ABM de diccionarios: localidades
 --------------------------------------------------------------------------------*/	
 
	public function localidades(){
		try{
			$crud = new grocery_CRUD();

			$crud->where('localidades.eliminado = 0');
			$crud->set_table('localidades');
			$crud->set_subject('Localidades');
			$crud->required_fields('localidad', 'codigo_postal', 'id_provincia');
			$crud->fields('localidad', 'codigo_postal', 'id_provincia');
			$crud->columns('localidad', 'codigo_postal', 'id_provincia');
			
			$crud->set_relation('id_provincia', 'provincias', 'provincia');
			$crud->display_as('id_provincia','Provincia');

			$output = $crud->render();

			$this->armar_vista_crud($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

/*--------------------------------------------------------------------------------	
 			ABM de diccionarios: convenios
 --------------------------------------------------------------------------------*/	
 
	public function convenios(){
		try{
			$crud = new grocery_CRUD();

			$crud->where('convenios.eliminado = 0');
			$crud->set_table('convenios');
			$crud->set_subject('convenios');
			$crud->required_fields('cod_convenio', 'convenio');
			$crud->fields('cod_convenio', 'convenio');
			$crud->columns('cod_convenio', 'convenio');
			$crud->display_as('cod_convenio','Código convenio');

			$output = $crud->render();

			$this->armar_vista_crud($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

/*--------------------------------------------------------------------------------	
 			ABM de diccionarios: feriados
 --------------------------------------------------------------------------------*/	

	public function feriados(){
		try{
			$crud = new grocery_CRUD();

			$crud->where('feriados.eliminado = 0');
			$crud->set_table('feriados');
			$crud->set_subject('Feriados');
			$crud->required_fields('feriado', 'fecha');
			$crud->fields('feriado', 'fecha');
			$crud->columns('feriado', 'fecha');
			
			$crud->display_as('id_provincia','Provincia');

			$output = $crud->render();

			$this->armar_vista_crud($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
}