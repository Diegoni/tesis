<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Afiliados extends My_Controller {

	protected $_subject		= 'afiliados';	
	
	function __construct(){

		parent::__construct(
			$subjet		= $this->_subject
		);
		
		$this->load->model('m_afiliados');
		$this->load->model('m_archivos');
		$this->load->model('m_boletas');
		$this->load->model('m_config_archivos');
		$this->load->model('m_entes');
		$this->load->model('m_localidades');
		$this->load->model('m_provincias');
		
		$this->load->helper(array('form', 'url'));

	} 

/*--------------------------------------------------------------------------------	
 			Administración de Afiliados: tabla
 --------------------------------------------------------------------------------*/	

	public function table($mensaje = NULL){
		if($mensaje != NULL) {
			$db['mensaje'] = $mensaje;
		}else{
			$db['mensaje'] = '';
		}	
		
		$db['registros'] = $this->m_afiliados->getAfiliados($this->_session_data['id_ente'], $this->_session_data['id_usuario']);
		
		$this->armar_vista('table', $db);
	}
	
/*--------------------------------------------------------------------------------	
 			Administración de Afiliados: Ajax para armar la tabla
 --------------------------------------------------------------------------------*/		
	
	public function ajax(){
		$registros = $this->m_afiliados->getAfiliados($this->_session_data['id_ente'], $this->_session_data['id_usuario']);
		$json				= "";
		if($registros){
			$btn_class			= "'btn btn-default'";
			$icon_class			= "'fa fa-pencil-square-o'";
			$bole_class			= "'fa fa-file-text-o'";
			$tarj_class			= "'fa fa-credit-card'";
			$title_modificar	= "'Modificar'";
			$title_boletas		= "'Boletas'";
			$title_tarjetas		= "'Tarjetas'";
			$url_modificar		= "'".base_url()."index.php/afiliados/abm/";
			$url_boletas		= "'".base_url()."index.php/boletas/table/";
			$url_tarjetas		= "'".base_url()."index.php/tarjetas/table/";
			if($this->_session_data['boletas'] == 1 && $this->_session_data['tarjetas'] == 1){
				foreach ($registros as $row) {
					$url_final = $row->id_afiliado."'";
					
					$buttons = '<a class='.$btn_class.' title='.$title_modificar.'  href='.$url_modificar.$url_final.'><i class='.$icon_class.'></i></a> ';
					$buttons .= ' <a class='.$btn_class.' title='.$title_tarjetas.' href='.$url_tarjetas.$url_final.'><i class='.$tarj_class.'></i></a> ';
					$buttons .= ' <a class='.$btn_class.' title='.$title_boletas.'  href='.$url_boletas.$url_final.'><i class='.$bole_class.'></i></a>';
					
					$registro = array(
						$row->nombre,
						$row->apellido,
						$row->codigo_afiliado,
						$buttons,
					);
					
					$json .= setJsonContent($registro);
				}
			}else if($this->_session_data['boletas'] == 1){
				foreach ($registros as $row) {
					$url_final = $row->id_afiliado."'";
					
					$buttons = '<a class='.$btn_class.' title='.$title_modificar.'  href='.$url_modificar.$url_final.'><i class='.$icon_class.'></i></a> ';
					$buttons .= ' <a class='.$btn_class.' title='.$title_boletas.'  href='.$url_boletas.$url_final.'><i class='.$bole_class.'></i></a>';
					
					$registro = array(
						$row->nombre,
						$row->apellido,
						$row->codigo_afiliado,
						$buttons,
					);
					
					$json .= setJsonContent($registro);
				}
			}else{
				foreach ($registros as $row) {
					$url_final = $row->id_afiliado."'";
					
					$buttons = '<a class='.$btn_class.' title='.$title_modificar.'  href='.$url_modificar.$url_final.'><i class='.$icon_class.'></i></a> ';
					$buttons .= ' <a class='.$btn_class.' title='.$title_tarjetas.' href='.$url_tarjetas.$url_final.'><i class='.$tarj_class.'></i></a> ';
					
					$registro = array(
						$row->nombre,
						$row->apellido,
						$row->codigo_afiliado,
						$buttons,
					);
					
					$json .= setJsonContent($registro);
				}
			}
			
			$json = substr($json, 0, -2);
		} 
		echo '{ "data": ['.$json.' ]  }';
	}
	
/*--------------------------------------------------------------------------------	
 			Administración de Afiliados: registro
 --------------------------------------------------------------------------------*/	
 
	public function abm($id = NULL){
		$vista				= '';
		$db['fields']		= $this->m_afiliados->getFields();
		$db['extra_fields'] = array('codigo');
		$id_table			= $this->m_afiliados->getId_Table();
		
		// DELETE 
		
		if($this->input->post('eliminar')){
			$boletas = $this->m_boletas->getBoletas($this->_session_data['id_ente'], $this->input->post('id_afiliado'), 'pagadas');
			
			if($boletas && $this->_config['delete_afiliado_boleta'] == 1){
				foreach ($boletas as $row) {
					$url = '<p><a href="'.base_url().'index.php/boletas/abm/'.$row->id_boleta.'">'.$this->lang->line('boleta_impaga').$row->id_boleta.'</a></p>';
					$this->alerta($url);
				}
				$db['mensaje']	= $this->lang->line('afiliado_no_delete');
			}else{
				$this->m_afiliados->delete($this->input->post($id_table));
				$db['mensaje']	= 'update_ok';
				$vista = 'table';
			}
		}
		
		// RESTAURAR
		
		if($this->input->post('restaurar')){
			$this->m_afiliados->restore($this->input->post($id_table));
			$db['mensaje']	= 'update_ok';
			$vista = 'table';
		}
		
		// UPDATE
		
		if($this->input->post('modificar')){
			foreach ($db['fields'] as $field) {
				if($this->input->post($field) !== NULL){
					$registro[$field] = $this->input->post($field);
				}
			}
			
			$this->m_afiliados->update($registro, $this->input->post($id_table));
			$this->m_afiliados->updateCodigo($this->input->post('codigo'), $this->input->post($id_table));
			$db['mensaje']	= 'update_ok';
			$vista = 'table';
		}
		
		if($id){
			$db['registro'] = $this->m_afiliados->getAfiliado($id);
			$db['cod_inc']	= FALSE;
		}else{
			$db['registro'] = FALSE;
			$campo = array('codigo_afiliado' => 'codigo');
			$where = array('id_ente' => $this->_session_data['id_ente']);
			$db['cod_inc']	= $this->m_afiliados->getMax($campo, 'afiliados_entes', $where);
		}
						
		// INSERT 
			
		if($this->input->post('agregar') || $this->input->post('agregar_per')){
			foreach ($db['fields'] as $field) {
				if($this->input->post($field) !== NULL){
					$registro[$field] = $this->input->post($field);
				}
			}
									
			$this->m_afiliados->insertAfiliado($registro, $this->_session_data['id_ente'], $this->input->post('codigo'));
			$db['mensaje']	= 'insert_ok';
			
			if($this->input->post('agregar')){
				$vista = 'table';
			}
		}
		
		// ARMADO DE VISTA
		
		if($vista != 'table'){
			$db['provincias'] = $this->m_provincias->getRegistros();
			$this->armar_vista('abm', $db);
		}else{
			$this->table($db['mensaje']);
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
		$config['allowed_types']	= $config_archivos['afiliados_type'];
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
		$this->load->library('excel'); // Cargamos libreria de excel, es la PHPExcel
		
		$archivo_path = $upload['file_path'].$this->_session_data['usuario'].'-'.date('Y_m_d H_i_s').'.xls';
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
		
		$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true); // Pasamos el excel a un array
		$arrayCount = count($allDataInSheet);// contamos la cantidad de elementos que tiene	
		
		if($this->controlArchivo($allDataInSheet[1], $upload['file_name'])){// Controlamos estructura y nombre del archivo.
			$estructura_archivo = array( // Armamos la estructura del archivo, donde el key es el dato y el value es la columna
				'A'	=> 'codigo_afiliado',
				'B' => 'nombre',
				'C' => 'apellido',
				'D' => 'calle',
				'E' => 'numero',
				'F' => 'piso',
				'G' => 'departamento',
				'H' => 'id_provincia',
				'I' => 'id_localidad',
				'J' => 'codigo_postal',
				'K' => 'telefono',
				'L' => 'email',
				'M' => 'fecha_alta',
			);
			
			if($arrayCount < $this->_config['maximo_afiliados_importacion']){
				if($arrayCount < $this->_config['maximo_afiliados_alertas']){
					for($i = 2; $i <= $arrayCount; $i++){
						foreach ($estructura_archivo as $key => $value) {
							$registro[$value] = trim($allDataInSheet[$i][$key]);	
						}
						
						$registro['id_provincia']	= $this->m_provincias->getID($registro['id_provincia']); // Buscamos el id que corresponda para provincia
						$registro['id_localidad']	= $this->m_localidades->getID($registro['id_localidad'], $registro['id_provincia'] ); // Buscamos el id que corresponda para localidad
						$registro['id_archivo']		= $id_archivo;
						
						$codigo = trim($allDataInSheet[$i]['A']);
					
						$afiliado = $this->m_afiliados->insertAfiliado($registro, $ente, $codigo); // Hacemos el insert del Afiliado en la base de datos
						
						if($afiliado['insert'] == 1){
							$test = $this->controlAfiliado($registro);
							if(!$test){
								if($this->_config['alerta_afiliado_incompleto'] == 1){
									$url = '<p><a href="'.base_url().'index.php/afiliados/abm/'.$afiliado['id_afiliado'].'">'.$this->lang->line('afiliado_incompleto').$afiliado['codigo_afiliado'].'</a></p>';
									$this->alerta($url);
								}
							}
						}else{
							if($this->_config['alerta_afiliado_existente'] == 1){
								$url = '<p><a href="'.base_url().'index.php/afiliados/abm/'.$afiliado['id_afiliado'].'">'.$this->lang->line('afiliado_existente').$afiliado['codigo_afiliado'].'</a></p>';
								$this->alerta($url);
							}
						}
					}
				}else{
					$date		= date('Y-m-d H:i:s');
					$codigos 	= $this->m_afiliados->getCodigos($ente);
					$provincias	= $this->m_provincias->getRegistros();
					foreach ($provincias as $row) {
						$array_provincias[$row->id_provincia] = $row->provincia;
					}
					
					if(!$codigos){
						$codigos = array();
					}
					
					for($i = 2; $i <= $arrayCount; $i++){
						$codigo = trim($allDataInSheet[$i]['A']);
						
						if(!in_array($codigo, $codigos)){
							$afiliado_ente[$i] = array(
								'id_ente'			=> $ente,
								'codigo_afiliado'	=> $codigo,
							);
							foreach ($estructura_archivo as $key => $value) {
								$registros[$i][$value] = trim($allDataInSheet[$i][$key]);
							}
							
							$registros[$i]['id_provincia']	= array_search(ucwords(strtolower($registros[$i]['id_provincia'])), $array_provincias);
							$registros[$i]['id_ente']		= $ente;
							$registros[$i]['codigo_afiliado']	= $codigo;
							$registros[$i]['date_add']		= $date;
							$registros[$i]['date_upd']		= $date;
							$registros[$i]['user_add']		= $this->_session_data['id_usuario'];
							$registros[$i]['user_upd']		= $this->_session_data['id_usuario'];
							$registros[$i]['id_archivo']	= $id_archivo;
						}
					}
					
					if(isset($registros)){
						$this->m_afiliados->insertMasivo($registros, $afiliado_ente, $ente);
					}
				}
	
				$this->table('update_ok');
			}else{
				$this->table('El máximo permitido de registros es '.$this->_config['maximo_afiliados_importacion'].' su archivo tiene '.$arrayCount);
			}
		}else{
			$mensaje = $this->lang->line('formato_incorrecto');;
			$this->upload($mensaje);
		}
	}
	
/*--------------------------------------------------------------------------------	
 			Importación de Excel: control estructura archivo
 --------------------------------------------------------------------------------*/	
	
	function controlArchivo($arrayCabecera, $nombreArchivo){
		$estructura_cabecera = array(
			'A'	=> 'Id Afiliado',	
			'B'	=> 'Nombre',
			'C'	=> 'Apellido',	
			'D'	=> 'Calle',	
			'E'	=> 'Nro',	
			'F'	=> 'Piso',	
			'G'	=> 'Depto',	
			'H'	=> 'Provincia',	
			'I'	=> 'Localidad',	
			'J'	=> 'CP',
			'K'	=> 'Teléfono',	
			'L'	=> 'Email',	
			'M'	=> 'Fecha Alta',
		);
		
		$bandera = TRUE;
		
		if($nombreArchivo != 'SRPAfiliados.xls'){ // Control nombre del archivo
			$bandera = FALSE;
		}else{
			foreach ($estructura_cabecera as $key => $value) { // Control de elementos de la cabecera
				if(!isset($arrayCabecera[$key]) || $arrayCabecera[$key] != $value){
					$bandera = FALSE;
				}
			}
		}
		
		return $bandera;
	}
	
/*--------------------------------------------------------------------------------	
 			Importación de Excel: control datos registro
 --------------------------------------------------------------------------------*/		
	
	function controlAfiliado($registro){
		$permitidos = array(
			'piso',
			'departamento'
			
		);
		
		foreach ($registro as $key => $value) {
			if($value == '' && !in_array($key, $permitidos)){
				return FALSE;
				break;
			}
		}
		
		return TRUE;
	}

/*--------------------------------------------------------------------------------	
 			Funciones para ajax: localidades de una provincia
 --------------------------------------------------------------------------------*/

	public function getLocalidades(){
		if($this->input->post('provincia')){
			$id_provincia = $this->input->post('provincia');
			$id_localidad = $this->input->post('id_localidad');				
			$departamentos 	= $this->m_localidades->getRegistros($id_provincia, 'id_provincia');
			
			echo '<option value="" disabled selected style="display:none;">Seleccione una opcion...</option>';
			foreach ($departamentos  as $row) {
				if($id_localidad == $row->id_localidad){
					echo '<option value="'.$row->id_localidad.'" selected>'.$row->localidad.'</option>';
				}else{
					echo '<option value="'.$row->id_localidad.'">'.$row->localidad.'</option>';
				}
			}
		}
	}

/*--------------------------------------------------------------------------------	
 			Funciones para ajax: código postal de una localidad
 --------------------------------------------------------------------------------*/
	
	public function getCodPostal(){
		if($this->input->post('localidad')){
			$id_localidad = $this->input->post('localidad');		
			$cod_postal = $this->m_localidades->getRegistros($id_localidad);
			
			foreach ($cod_postal  as $row) {
				echo $row->codigo_postal;
			}
		}			
	}

/*--------------------------------------------------------------------------------	
 			Funciones para ajax: control de codigo existente
 --------------------------------------------------------------------------------*/
 
	public function getCodigo(){
		if($this->input->post('codigo')){		
			$control = $this->m_afiliados->controlCodigo($this->input->post('codigo'), $this->input->post('id_ente'), $this->input->post('id_afiliado'));
			
			echo $control;
		}else{
			echo 2;
		}			
	}
}
