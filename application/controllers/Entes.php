<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entes extends My_Controller {

	protected $_subject		= 'entes';
	protected $url_siris	= 'http://172.31.24.177/WsSiris_26/emp_6100.php';
	protected $usar_noti	= 1; //1 = SI, 0 = NO
	
	function __construct(){
		parent::__construct(
				$subjet		= $this->_subject 
		);
		
		$this->load->model('m_archivos');
		$this->load->model('m_boletas');
		$this->load->model('m_convenios');
		$this->load->model('m_config');
		$this->load->model('m_config_archivos');
		$this->load->model('m_entes');
		$this->load->model('m_impresiones');
		$this->load->model('m_leyendas');
		$this->load->model('m_notificaciones');
		
		$this->load->helper(array('form', 'url'));
	} 
		

/*--------------------------------------------------------------------------------	
 			Administracion de entes: table
 --------------------------------------------------------------------------------*/	

	public function table($mensaje = NULL){
		if($this->_session_data['id_perfil'] == 2){
			$db['registros'] = $this->m_entes->getEntes($this->_session_data['id_usuario']);
		}else{
			$db['registros'] = $this->m_entes->getRegistros();
		}
			
		if($mensaje != NULL) {
			$db['mensaje'] = $mensaje;
		}
			
		$this->armar_vista('table', $db);
	}
	
/*--------------------------------------------------------------------------------	
 			Administración de entes: ajax para armar tabla
 --------------------------------------------------------------------------------*/	
 	
	public function ajax($id_afiliado = NULL){
		if($this->_session_data['id_perfil'] == 2){
			$registros = $this->m_entes->getEntes($this->_session_data['id_usuario']);
		}else{
			$registros = $this->m_entes->getRegistros();
		}
		
		$json = "";
		if($registros){
			$btn_class = "'btn btn-default'";
			$icon_class = "'fa fa-pencil-square-o'";
			$title_modificar = "'modificar'";
			$url_ent_i = "'".base_url()."index.php/entes/abm/";

			foreach ($registros as $row) {
				$url_ent_f = $row->id_ente."'";
				
				$registro = array(
					$row->nombre,
					$row->codigo,
					$row->cuit,
					$row->telefono,
					getCheck($row->boletas),
					getCheck($row->tarjetas),
					'<a href='.$url_ent_i.$url_ent_f.' class='.$btn_class.'><i class='.$icon_class.'></i></a>'
				);
				
				$json .= setJsonContent($registro);
			}
			
			$json = substr($json, 0, -2);
		}
		echo '{ "data": ['.$json.' ]  }';
	}
	
/*--------------------------------------------------------------------------------	
 			Administracion de entes: registro
 --------------------------------------------------------------------------------*/		
	
	public function abm($id = NULL){
		$vista 			= '';
		$db['fields']	= $this->m_entes->getFields();
		$id_table		= $this->m_entes->getId_Table();
		$checkbox		= array(
			'boletas',
			'tarjetas',
			'bloquear'
		);
		
		// DELETE 
		
		if($this->input->post('eliminar')){
			$boletas = $this->m_boletas->getBoletas($this->input->post($id_table), 0, 1);
			
			if($boletas && $this->_config['delete_ente_boleta'] == 1){
				$url = '<p><a href="'.base_url().'index.php/entes/abm/'.$this->input->post($id_table).'">'.$this->lang->line('boleta_impaga_cant').count($boletas).'</a></p>';
				$this->alerta_banco($url);
				
				$db['mensaje']	= $this->lang->line('ente_no_delete');
			}else{
				if($this->usar_noti == 1){
					$this->notificacionSiris($this->input->post($id_table), 'B');	
				}
				$this->m_entes->delete($this->input->post($id_table));
				$db['mensaje']	= 'update_ok';
				$vista = 'table';
			}
		}
		
		// UPDATE
		
		if($this->input->post('modificar')){
			
			foreach ($db['fields'] as $field) {
				if($this->input->post($field) !== NULL){
					$registro[$field] = $this->input->post($field);
				}
			}
			
			foreach ($checkbox as $box) {
				if($this->input->post($box) !== null){
					$registro[$box] = 1;
				}else{
					$registro[$box] = 0;
				}
			}
			
			if($this->usar_noti == 1){
				$this->notificacionSiris($this->input->post($id_table), 'M');	
			}
			$this->m_entes->update($registro, $this->input->post($id_table));
			$db['mensaje']	= 'update_ok';
			$vista = 'table';
		}
		
		if($id){
			$db['cod_inc']	= FALSE;
			$db['registro'] = $this->m_entes->getRegistros($id);
		}else{
			$db['cod_inc']	= $this->m_entes->getMax('codigo');
			$db['registro'] = FALSE;
		}

		// RESTAURAR 

		if($this->input->post('restaurar')){
			if($this->usar_noti == 1){
				$this->notificacionSiris($this->input->post($id_table), 'A');	
			}
			$this->m_entes->restore($this->input->post($id_table));
			$db['mensaje']	= 'update_ok';
			$vista = 'table';
		}
						
		// INSERT 
			
		if($this->input->post('agregar') || $this->input->post('agregar_per')){
			foreach ($db['fields'] as $field) {
				if($this->input->post($field) !== NULL){
					$registro[$field] = $this->input->post($field);
				}
			}
			
			foreach ($checkbox as $box) {
				if($this->input->post($box) !== null){
					$registro[$box] = 1;
				}else{
					$registro[$box] = 0;
				}
			}
			$id_ente = $this->m_entes->insertEntes($registro);
			
			if($id_ente){
				$db['mensaje']	= 'insert_ok';
			}
			
			if($this->usar_noti == 1){
				$this->notificacionSiris($id_ente, 'A');	
			}
			
			if($this->input->post('agregar')){
				$vista = 'table';
			}
		}
		
		// ARMADO DE VISTA
		
		if($vista != 'table'){
			$db['leyendas']		= $this->m_leyendas->getRegistros();
			$db['convenios']	= $this->m_convenios->getRegistros();
			$this->armar_vista('abm', $db);
		}else{
			if(isset($db['mensaje'])){
				$this->table($db['mensaje']);
			}else{
				$this->table();
			}
			
		}
	}

/*--------------------------------------------------------------------------------	
 			Funciones para ajax: control de codigo
 --------------------------------------------------------------------------------*/	
 
	public function getCodigo(){
		if($this->input->post('codigo')){		
			$control = $this->m_entes->controlCodigo($this->input->post('codigo'), $this->input->post('id_ente'));
			
			echo $control;
		}else{
			echo 2;
		}			
	}
	
/*--------------------------------------------------------------------------------	
 			Funciones para ajax: control de cuit
 --------------------------------------------------------------------------------*/	
 	
	public function validarCuit(){
		if($this->input->post('cuit')){
			$cuit =	str_replace ( '-' , '' , $this->input->post('cuit'));	
			if(validarCUIT($cuit)){
				echo 1;
			}else{
				echo 0;
			}
		}else{
			echo 0;
		}	
	}

/*--------------------------------------------------------------------------------	
 			Importación de Excel: formulario
 --------------------------------------------------------------------------------*/

	function upload($mensaje = NULL){	
		$db = '';
		
		if($mensaje != NULL){
			$db['mensaje']	= $mensaje;
		}
			
		$this->armar_vista('upload_form', $db);
	}

/*--------------------------------------------------------------------------------	
 			Importación de Excel: upload del archivo
 --------------------------------------------------------------------------------*/

	function do_upload(){
		$config_archivos 			= $this->m_config_archivos->getConfig();
		
		$config['upload_path']		= $this->_upload.$this->_subject.'/' ; // Configuramos algunos parametros 
		$config['allowed_types']	= $config_archivos['afiliados_type'].'|xlsx';
		$config['max_size']			= $config_archivos['afiliados_size'];

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload()){ // Controlamos upload, si no se realizo mostramos error
			$mensaje = $this->upload->display_errors();
			$this->upload($mensaje);
		} else { // Si se realizo el upload, enviamos a importacion los datos
			$this->importacion($this->upload->data(), $this->_session_data['id_ente']);
		}
	}
	
/*--------------------------------------------------------------------------------	
 			Importación de Excel: carga de datos
 --------------------------------------------------------------------------------*/	
	
	function importacion($upload, $ente){
		$this->load->library('excel');
		
		$archivo_path = $upload['file_path'].'Entes-'.date('Y_m_d H_i_s').'.xls';
		rename($upload['file_path'].$upload['file_name'],  $archivo_path);
		
		$archivo = array(
			'nombre'		=> $this->_session_data['usuario'].'-'.date('Y_m_d H_i_s'),
			'extension'		=> $upload['file_ext'],
			'path'			=> $upload['file_path'],
			'size'			=> $upload['file_size'],
			'tipo'			=> $upload['file_type'],
			'full_path'		=> $archivo_path,
			'id_origen'		=> 1,
			'id_usuario'	=> $this->_session_data['id_usuario'],
			'id_ente'		=> $this->_session_data['id_ente'],
		);
		$id_archivo = $this->m_archivos->insert($archivo);
			
		try {
			$objPHPExcel = PHPExcel_IOFactory::load($archivo_path); // Leemos el archivo	
		} catch(Exception $e) {
			die(log_message('ERROR', 'Error cargando el archivo "'.pathinfo($archivo_path,PATHINFO_BASENAME).'": '.$e->getMessage()));
		}
		
		$convenios_obj = $this->m_convenios->getRegistros();
		foreach ($convenios_obj as $row_convenio) {
			$array_convenios[$row_convenio->id_convenio] = $row_convenio->cod_convenio;
		}
		
		$estructura_archivo = array(
			'barra',
			'codigo',
			'fecha_alta',
			'usuario',
			'ente',
			'cod_convenio',
			'leyenda',
			'imprime_cuota',
			'modalidad',
			'comentario',
			'id',
		);
		
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
			$cell = $worksheet->getCellByColumnAndRow(2, 1);
			$titulo = $cell->getValue();
			
			if($titulo == 'ent_FechaAlta'){
				$this->insertEnte($worksheet, $array_convenios, $estructura_archivo);
			}else if($titulo == 'habilitado'){
				$this->extrafieldEnte($worksheet);
			}
		}		
		
		$this->table('update_ok');
	}

/*--------------------------------------------------------------------------------	
 			Importación de Excel: Insertar ente desde archivo
 --------------------------------------------------------------------------------*/	

	function insertEnte($worksheet, $array_convenios, $estructura_archivo){
		$highestRow         = $worksheet->getHighestRow(); // e.g. 10
		$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
		
		for ($row = 2; $row <= $highestRow; ++ $row) {
			for ($col = 0; $col < $highestColumnIndex; ++ $col) {
				$cell = $worksheet->getCellByColumnAndRow($col, $row);
				$registro[$estructura_archivo[$col]] = $cell->getValue();
			}
				
			$ente_array		= array(
				'codigo'		=> $registro['codigo'],
				'nombre'		=> $registro['ente'],
				'imprime_cuota' => $registro['imprime_cuota'],
				'modalidad'		=> $registro['modalidad'],
				'comentario'	=> $registro['comentario'],				
			);	
				
			if($registro['barra'] == '6100'){
				$ente_array['boletas']	= 1;
				$ente_array['tarjetas'] = 0;
			}else if($registro['barra'] == '6200'){
				$ente_array['boletas']	= 0;
				$ente_array['tarjetas'] = 1;
			}	
				
			$timestamp	= PHPExcel_Shared_Date::ExcelToPHP($registro['fecha_alta']);
			$ente_array['fecha_alta'] = date("Y-m-d H:i:s",$timestamp);
					
			if($registro['leyenda'] == 'E'){
				$ente_array['id_leyenda'] = 4;
			} else {
				$ente_array['id_leyenda'] = 1;
			}
					
			$ente_array['id_convenio'] = 0;	
			foreach ($array_convenios as $key => $value) {
				if($registro['cod_convenio'] == $value){
					$ente_array['id_convenio'] = $key;
				}
			}
					
			$id_ente = $this->m_entes->insert($ente_array);
			$insertEntes[] = $id_ente;
				
			$usuario_obj = $this->m_usuarios->getRegistros($registro['usuario'], 'usuario');
			if($usuario_obj){
				foreach ($usuario_obj as $row_usuario) {
					$id_usuario = $row_usuario->id_usuario;
				}
			}else{
				$usuario = array(
					'usuario'	=> $registro['usuario'],
					'pass'		=> encrypt(random_string(6)),
					'id_perfil'	=> 2,
				);
				$id_usuario = $this->m_usuarios->insert($usuario);
			}
				
			$this->m_usuarios->setEntes($id_ente, $id_usuario);
		}
		if($this->usar_noti == 1){
			$email = '';
			$notificaciones = '';
	
			foreach ($insertEntes as $id) {
				$return = $this->notificacionSiris($id, 'A', 'archive');
				if($return['flag'] == 'ok'){
					$notificaciones[] = $return['result'];
				}else{
					$email .= $return['result'];
				}
			}
	
			if($notificaciones != ''){
				$this->db->insert_batch('notificaciones', $notificaciones);
			}		
			
			if($email != ''){
				$this->emailAdmin($email);	
			}	
		}
	}

/*--------------------------------------------------------------------------------	
 			Importación de Excel: carga extra fields de ente 
 --------------------------------------------------------------------------------*/	

	function extrafieldEnte($worksheet){
		$highestRow         = $worksheet->getHighestRow(); // e.g. 10
		$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
		
		for ($row = 2; $row <= $highestRow; ++ $row) {
			$rec_ID_1 	= $worksheet->getCellByColumnAndRow(1, $row);
			$habilitado = $worksheet->getCellByColumnAndRow(2, $row);
			$bloquear 	= $worksheet->getCellByColumnAndRow(3, $row);
			
			$registro['bloquear'] = $bloquear->getValue();
			if($habilitado->getValue() == 0){
				$registro['eliminado'] = 1;
			}else{
				$registro['eliminado'] = 0;
			}
			$registro['codigo']	= substr($rec_ID_1->getValue(), 4);
			
			$this->m_entes->extraField($registro);		
		}
	}
	
/*--------------------------------------------------------------------------------	
 			Enviamos los cambios al otro sistema
 --------------------------------------------------------------------------------*/	

	function notificacionSiris($id, $accion, $method = NULL){
		//op string 1 caracter: A,B,M (para alta, baja o modificacion)
		//empresa id empresa, formateado 4 digitos ej "0001"
		//flags string 6 caracteres ej "010C30"
		//descripcion nombre de la empresa
		//hash md5(date("YmdHi",time())."kdif87776323_#LLkp..");
		
		$registro = $this->m_entes->getRegistros($id);
		
		if($registro){
			foreach ($registro as $row) {
				if($row->eliminado == 0){
					$flags = 1;	
				}else{
					$flags = 0;
				}
				$flags .= $row->bloquear;
				$flags .= $row->cod_convenio;
				$flags .= $row->letra_leyenda;
				$flags .= $row->modalidad;
				$flags .= $row->imprime_cuota;
				
				$codigo = $row->codigo;
				$nombre = $row->nombre;
			}
			
			if(strlen($codigo) < 4){
				$cantidad = 4 - strlen($codigo); 
				for ($i = 0; $i < $cantidad; $i++) { 
					$codigo = '0'.$codigo;
				}
			}
			
			$data = array(
				'op'			=> $accion, 
				'empresa'		=> $codigo,
				'flags'			=> $flags,
				'descripcion'	=> $nombre,
				'hash'			=> md5(date("YmdHi",time())."kdif87776323_#LLkp.."),
			);
			
			$options = array(
			    'http' => array(
			        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			        'method'  => 'POST',
			        'content' => http_build_query($data)
			    )
			);
			
			$context	= stream_context_create($options);
			$result		= file_get_contents($this->url_siris, false, $context);
			
			if($result === FALSE){
				$return['flag']		= 'error';
				$return['result']	= 'No hay conexión con '.$this->url_siris.'<br>';
			}else if($result != 'Ok'){
				$return['flag']		= 'error';
				$return['result']	= $result.' al '.$accion.' el ente id:'.$id.' codigo:'.$codigo.'<br>';
			}else{
				$registro = $data;
				$registro['result']	= $result;
				$return['flag']		= 'ok';
			}	
			
			
			if($return['flag'] == 'ok'){
				$registro['date_add']	= date('Y-m-d H:i:s');
				$registro['user_add']	= $this->_session_data['id_usuario'];
				$return['result'] = $registro;
			}
			
			if($method == 'archive'){
				return $return;
			} else {
				if($return['flag'] == 'error'){
					$this->emailAdmin($return['result']);	
				}else{
					$this->m_notificaciones->insert($registro);
				}
			}
		}
	}	
}