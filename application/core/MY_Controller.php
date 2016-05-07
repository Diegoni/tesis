<?php
class MY_Controller extends CI_Controller{
	protected $_subject;
	protected $logout = '/login/logout/';
	protected $_session_data;
	protected $_config;
	protected $_upload;
	
	protected $emailCopy	= array();
	protected $emailSubjet	= 'SRP INFO';
	protected $emailFrom	= 'diego.nieto@xnlatam.com';
	protected $emailTo		= 'diego.nieto@xnlatam.com';
	
	
    public function __construct($subjet){
    	$this->_subject		= $subjet;
		$this->_upload 	= './uploads/';
        parent::__construct();
		
		$this->load->model('m_alertas');
		$this->load->model('m_config');
		$this->load->model('m_emails');
		$this->load->model('m_logs_usuarios');
		$this->load->model('m_permisos');
		$this->load->model('m_usuarios');
		
		$this->load->library(array('table','pdf'));
		
		if($subjet != 'home'){
			$this->setDatos();
		}
    }
	
/*-------------------------------------------------------------------------------	
 --------------------------------------------------------------------------------
 			Armado de vista
 --------------------------------------------------------------------------------
 --------------------------------------------------------------------------------*/
	
	function armar_vista($vista, $db = NULL, $session_data = NULL){
		if($session_data !== NULL){
			$this->setDatos();
		}
		
		$db['permisos']		=  $this->getPermisos();
		$db['alertas_user']	=  $this->getAlertas();

		if($db['permisos']['ver'] == 0){
			redirect($this->logout, 'refresh');
		}else{
			$db['permisos_menu']	= $this->m_permisos->getRegistros($this->_session_data['id_perfil'], 'id_perfil');
			$db['config']			= $this->_config;
			$db['session_data'] 	= $this->_session_data;
			$db['subjet']			= ucwords($this->_subject);
			
			$this->load->view('plantilla/head', $db);
			$this->load->view('plantilla/menu-top');
			$this->load->view('plantilla/menu-left');
			$this->load->view($this->_subject.'/'.$vista);
			$this->load->view('plantilla/footer');
		}
	}

/*-------------------------------------------------------------------------------	
 --------------------------------------------------------------------------------
 			Armado de vista crud
 --------------------------------------------------------------------------------
 --------------------------------------------------------------------------------*/
	
	public function armar_vista_crud($output = null){
		$db['permisos']		=  $this->getPermisos();
		$db['alertas_user']	=  $this->getAlertas();
			
		if($db['permisos']['ver'] == 0){
			redirect($this->logout, 'refresh');
		}else{
			$db['permisos_menu']	= $this->m_permisos->getRegistros($this->_session_data['id_perfil'], 'id_perfil');
			$db['config']			= $this->_config;
			$db['session_data'] 	= $this->_session_data;
			$db['subjet']			= ucwords($this->_subject);
			
			$this->load->view('plantilla/head', $db);
			$this->load->view('plantilla/menu-top');
			$this->load->view('plantilla/menu-left');
			$this->load->view($this->_subject.'/crud', $output);
			$this->load->view('plantilla/footer');
		}
	}
	
/*-------------------------------------------------------------------------------	
 --------------------------------------------------------------------------------
 			Permisos
 --------------------------------------------------------------------------------
 --------------------------------------------------------------------------------*/	

	function getPermisos(){
		$permisos = $this->m_permisos->getPermisos($this->_subject, $this->_session_data['id_perfil']);
		
		foreach ($permisos as $row) {
			$db['permisos']['ver']			= $row->ver;
			$db['permisos']['agregar']		= $row->agregar;
			$db['permisos']['modificar']	= $row->modificar;
			$db['permisos']['eliminar'] 	= $row->eliminar;
		}

		return $db['permisos'];
	}
	
/*-------------------------------------------------------------------------------	
 --------------------------------------------------------------------------------
 			Cargar alertas del usuario
 --------------------------------------------------------------------------------
 --------------------------------------------------------------------------------*/	
	
	function getAlertas(){
		if($this->_session_data['id_perfil'] == 1){
			$db['alertas_user'] = $this->m_alertas->getAlertas($this->_session_data['id_usuario']);
		}else{
			$db['alertas_user'] = $this->m_alertas->getAlertas($this->_session_data['id_usuario'], $this->_session_data['id_ente']);
		}
		
		return $db['alertas_user'];	
	}

/*-------------------------------------------------------------------------------	
 --------------------------------------------------------------------------------
 			Cargar datos de session y de configuracion de la aplicacion
 --------------------------------------------------------------------------------
 --------------------------------------------------------------------------------*/	
	
	function setDatos(){
		if($this->session->userdata('logged_in')){
			$this->_session_data = $this->session->userdata('logged_in');
			$this->_config		 = $this->m_config->getConfig();
		} else 	{
			redirect($this->logout, 'refresh');
		}
	}

/*-------------------------------------------------------------------------------	
 --------------------------------------------------------------------------------
 			Alertas : usuarios
 --------------------------------------------------------------------------------
 --------------------------------------------------------------------------------*/	
	
	function alerta($alerta){
		$session_data = $this->session->userdata('logged_in');
		
		$registro = array(
			'alerta'		=> $alerta,
			'id_usuario'	=> $session_data['id_usuario'],
			'id_ente'		=> $session_data['id_ente'],
			'visto'			=> 0
		);
		
		$this->m_alertas->insert($registro);
	}

/*-------------------------------------------------------------------------------	
 --------------------------------------------------------------------------------
 			Alertas : bancos
 --------------------------------------------------------------------------------
 --------------------------------------------------------------------------------*/	

	function alerta_banco($alerta){
		$bancos = $this->m_usuarios->getRegistros(1, 'id_perfil');
		
		if($bancos){
			foreach ($bancos as $row) {
				$registro = array(
					'alerta'		=> $alerta,
					'id_usuario'	=> $row->id_usuario,
					'visto'			=> 0
				);
				
				$this->m_alertas->insert($registro);
			}
		}
	}
	
/*-------------------------------------------------------------------------------	
 --------------------------------------------------------------------------------
 			Exportación de tablas
 --------------------------------------------------------------------------------
 --------------------------------------------------------------------------------*/	
	
	function armarExport(){
		$tabla = strip_tags($this->input->post('datos_a_enviar'), '<table><tr><td><th>');
		
		if($this->input->post('export') == 'pdf'){
			foreach ($this->input->post('cabeceras') as $cabecera) {
				if($cabecera != 'Opciones'){
					$cabeceras[] = utf8_decode($cabecera);
				}
			}
			$this->armarPdf($tabla, $cabeceras);
		}else if($this->input->post('export') == 'excel'){
			$this->armarExcel($tabla);
		}else if($this->input->post('export') == 'print'){
			$this->armarPrint($tabla);
		}else{
			$post_data = $this->input->post(NULL, TRUE); 
			foreach ($post_data as $key => $value) {
				log_message('ERROR', 'No entro en ningun lado => '.$key);
			}
			
		}
	}
	
/*-------------------------------------------------------------------------------	
 --------------------------------------------------------------------------------
 			Exportación de tablas: Excel
 --------------------------------------------------------------------------------
 --------------------------------------------------------------------------------*/	

	function armarExcel($tabla){
		header("Content-type: application/vnd.ms-excel; name='excel'; charset=UTF-8");
		header("Content-Disposition: filename=ficheroExcel.xls");
		header("Pragma: no-cache");
		header("Expires: 0");

		echo "\xEF\xBB\xBF";
		echo $tabla;
	}
	
/*-------------------------------------------------------------------------------	
 --------------------------------------------------------------------------------
 			Exportación de tablas: Impresión
 --------------------------------------------------------------------------------
 --------------------------------------------------------------------------------*/	
	
	function armarPrint($tabla){
		echo $tabla;
		echo '<script>
				window.print();
				setTimeout(window.close, 0);
			</script>';
	}
	
/*-------------------------------------------------------------------------------	
 --------------------------------------------------------------------------------
 			Exportación de tablas: PDF
 --------------------------------------------------------------------------------
 --------------------------------------------------------------------------------*/	
	
	function armarPdf($tabla, $cabeceras){
		$dom = new DOMDocument();
		$doc = $dom->loadXml($tabla);
			
		$contador = 0;
			
		if(!empty($doc)){
			$dom->preserveWhiteSpace = false; //borramos los espacios en blanco 
			$tables = $dom->getElementsByTagName('table'); //obtenemos el tag table
			$rows = $tables->item(0)->getElementsByTagName('tr'); //array con todos los tr
			$i = 0;//recorremos el array
				
			foreach ($rows as $row){ 
				$cols = $row->getElementsByTagName('td');
					
				foreach ($cabeceras as $key => $value) {
					if(isset($cols->item($key)->nodeValue) ){
						$registros[$i][$value] = $cols->item($key)->nodeValue;
					}else{
						$registros[$i][$value] = '-';
					}
				}
					
				$k = 0;
					
				foreach ($registros[$i] as $key => $value) {
					if($value == '-' || $value == ''){
						$k = $k + 1;
					}
					
					if($k == count($registros[$i])){
						unset($registros[$i]);
					}
				}
				$i = $i + 1;
			}
			
			// set HTTP response headers
		   	$data['title']		='Registros'; 
			$data['author']		='Admin';
			$data['content']	= $registros; 
				
			$this->load->view('plantilla/pdf', $data);
		 	
		}
	}

/*-------------------------------------------------------------------------------	
 --------------------------------------------------------------------------------
 			Enviar email superadmin
 --------------------------------------------------------------------------------
 --------------------------------------------------------------------------------*/	
 
	function emailAdmin($mensaje){
		$emailConfig = array(
			'protocol' => 'smtp',
			'smtp_host' => '192.168.100.26',
			//'smtp_port' => '',
			'smtp_user' => '',
			'smtp_pass' => '',
			'charset' => 'utf-8',
			'mailtype' => 'html',
			'newline' => '\\r\
',
			'crlf' => '\\r\
'
		);
		$this->load->library('email',$emailConfig);
		$this->email->set_newline('\\r\
');
		

		$this->email->from($this->emailFrom, 'SRP');
		$this->email->to($this->emailTo); 
		
		$copy = '';
		foreach ($this->emailCopy as $email) {
			$this->email->cc($email); 
			$copy = $email.', ';
		}
		
		$this->email->subject($this->emailSubjet);
		$this->email->message($mensaje);	
		
		$this->email->send();
		
		$registro = array(
			'mail_to'		=> $this->emailTo,
			'mail_copy'		=> $copy,
			'mail_subject'	=> $this->emailSubjet,
			'message'		=> $mensaje,
			'mail_from'		=> $this->emailFrom,
			'debugger'		=> $this->email->print_debugger(),
		);
		
		$this->m_emails->insert($registro);
	}
}