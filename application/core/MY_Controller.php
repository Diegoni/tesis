<?php
class MY_Controller extends CI_Controller
{
	protected $_subject;
    protected $_model;
	protected $logout      = '/login/logout/';
	protected $_session_data;
	protected $_config;
	protected $_upload;
	
	protected $emailCopy	= array();
	protected $emailSubjet	= 'SRP INFO';
	protected $emailFrom	= 'diego.nieto@xnlatam.com';
	protected $emailTo		= 'diego.nieto@xnlatam.com';
	
	
    public function __construct($subjet, $model)
    {
        
    	$this->_subject		= $subjet;
		$this->_upload 	= './uploads/';
        parent::__construct();
		
		$this->load->library(array('table','pdf', '../core/benchmark'));
        $this->benchmark->mark('inicio');
		
        if($this->_model != '')
        {
            $this->load->model($this->_model, 'model');    
        }
        
        $this->load->model('m_usuarios_permisos');
        $this->load->model('m_logs_usuarios');
    }
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Función para armar las vistas de tablas
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/


    function table($mensaje = NULL, $db = NULL)
    {
        if($mensaje != NULL) 
        {
            $db['mensaje'] = $mensaje;
        }
        
        $db['registros']   = $this->model->getRegistros();
        $this->armarVista('table', $db);
    }
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Función para armar un abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/ 

    
    function armarAbm($id = NULL, $db = NULL)
    {
        $vista              = 'abm';
        $db['fields']       = $this->model->getFields();
        $db['id_table']     = $this->model->getIdTable();
        
        if($this->input->post($db['id_table']))
        {
            $id_post = $this->input->post($db['id_table']);
        }
                
        // DELETE 
        
        if($this->input->post('eliminar'))
        {
            if (method_exists($this, 'beforeDelete')) 
            {
                $registro = $this->beforeDelete($id_post);
            }  
            
            $this->model->delete($id_post);
            
            if (method_exists($this, 'afterDelete')) 
            {
                $registro = $this->afterDelete($id_post);
            }
            
            $db['mensaje']  = 'update_ok';
            $vista = 'table';
        }
        
        // RESTAURAR
        
        if($this->input->post('restaurar'))
        {
            if (method_exists($this, 'beforeRestore')) 
            {
                $registro = $this->beforeRestore($id_post);
            }       
            
            $this->model->restore($id_post);
            
            if (method_exists($this, 'afterRestore')) 
            {
                $registro = $this->afterRestore($id_post);
            }       
            
            $db['mensaje']  = 'update_ok';
            $vista = 'table';
        }
        
        // UPDATE
        
        if($this->input->post('modificar'))
        {
            foreach ($db['fields'] as $field) 
            {
                if($this->input->post($field) !== NULL)
                {
                    $registro[$field] = $this->input->post($field);
                }
            }
        
            if($db['campos'] !== NULL)
            {
                foreach ($db['campos'] as $campo) 
                {
                    if($campo[0] == 'checkbox')
                    {
                        if($this->input->post($campo[1]) !== null)
                        {
                            $registro[$campo[1]] = 1;
                        }else{
                            $registro[$campo[1]] = 0;
                        }
                    }
                }    
            } 
            
            if (method_exists($this, 'beforeUpdate')) 
            {
                $registro = $this->beforeUpdate($registro);
            }       
            
            if(is_array($registro))
            {
                $this->model->update($registro, $id_post);
                
                if (method_exists($this, 'afterUpdate')) 
                {
                    $registro = $this->afterUpdate($registro, $id_post);
                }  
                 
                $db['mensaje']  = 'update_ok';
                $vista = 'table';    
            }else
            {
                $db['mensaje']  = $registro;
                $vista          = 'abm';
            }            
        }            
                    
        // INSERT 
            
        if($this->input->post('agregar') || $this->input->post('agregar_per'))
        {
            foreach ($db['fields'] as $field) 
            {
                if($this->input->post($field) !== NULL)
                {
                    $registro[$field] = $this->input->post($field);
                }
            }
            
            if($db['campos'] !== NULL)
            {
                foreach ($db['campos'] as $campo) 
                {
                    if($campo[0] == 'checkbox')
                    {
                        if($this->input->post($campo[1]) !== null)
                        {
                            $registro[$campo[1]] = 1;
                        }else
                        {
                            $registro[$campo[1]] = 0;
                        }
                    }
                }    
            }
            
            if (method_exists($this, 'beforeInsert')) 
            {
                $registro = $this->beforeInsert($registro);
            }
            
            if(is_array($registro))
            {
                $id = $this->model->insert($registro);
            
                if (method_exists($this, 'afterInsert')) 
                {
                    $registro = $this->afterInsert($registro, $id);
                }    
                
                if($this->input->post('agregar'))
                {
                    $db['mensaje']  = 'insert_ok';
                    $vista = 'table';
                }else 
                {
                    $db['mensaje']  = 'insert_ok';
                    $vista = 'abm';
                }
            }else
            {
                $db['mensaje']  = $registro;
                $vista          = 'abm';
            }  
        }

        // Carga de datos en el formulario
        
        if($id)
        {
            $db['registro'] = $this->model->getRegistros($id); 
        }else
        {
            $db['registro'] = FALSE;
        }
        
        // ARMADO DE VISTA
        
        if($vista != 'table')
        {
            $this->armarVista($vista, $db);
        }else
        {
            $this->table($db['mensaje']);
        }
    }
	
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Función para la vista con la estructura de la pagina
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/ 
	
	
	function armarVista($vista, $db = NULL, $session_data = NULL)
	{
	    $permiso = 0;
        
	    if($this->session->userdata('logged_in'))
	    {
	        $db['session'] = $this->session->userdata('logged_in');
            $db['subjet']  = ucwords($this->_subject);
            
            if($vista == 'abm')
            {
                $_vista = 'table';
            }else
            {
                $_vista = $vista;
            }
            
            $db['permiso_editar'] = 0;
            
            if(isset($db['session']['permisos']))
            {
                foreach ($db['session']['permisos'] as $key => $value) 
                {
                    if(strtolower($this->_subject.'/'.$_vista.'/') == strtolower($value['url']) && $value['ver'] == 1)
                    {
                        $permiso = 1;  
                        $db['permiso_editar'] =  $value['editar'];
                    } 
                }    
            }
            
            if($permiso == 1)
            {
                if(strtolower($this->_subject.'/'.$vista) != 'logs_usuarios/abm')
                {
                     $this->setLog(4, $this->_subject.'/'.$vista, 'access');
                }
                
                $this->benchmark->mark('final');
                     
                $this->load->view('plantilla/head', $db);
                $this->load->view('plantilla/menu-top');
                $this->load->view('plantilla/menu-left');
                $this->load->view($this->_subject.'/'.$vista);
                $this->load->view('plantilla/footer'); 
            }else 
            {
               $this->setLog(4, $this->_subject.'/'.$vista.'/', 'denied_access');
               redirect($this->logout, 'refresh'); 
            }
        }else  
        {
            redirect($this->logout, 'refresh');
        }
	}


/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Función para la vista de crud
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/ 

	
	public function armarVistaCrud($output = null)
	{
		$db['permisos']		=  $this->getPermisos();
		$db['alertas_user']	=  $this->getAlertas();
			
		if($db['permisos']['ver'] == 0)
		{
			redirect($this->logout, 'refresh');
		}else
		{
			$db['config']			= $this->_config;
			$db['subjet']			= ucwords($this->_subject);
            $this->setLog(3, 'Acceso a '.$this->_subject.'/crud');
			
			$this->load->view('plantilla/head', $db);
			$this->load->view('plantilla/menu-top');
			$this->load->view('plantilla/menu-left');
			$this->load->view($this->_subject.'/crud', $output);
			$this->load->view('plantilla/footer');
		}
	}
	
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Función para filtrar permisos de usuario
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/ 


	function getPermisos()
	{
		$permisos = $this->m_permisos->getPermisos($this->_subject, $this->_session_data['id_perfil']);
		
		foreach ($permisos as $row) 
		{
			$db['permisos']['ver']			= $row->ver;
			$db['permisos']['agregar']		= $row->agregar;
			$db['permisos']['modificar']	= $row->modificar;
			$db['permisos']['eliminar'] 	= $row->eliminar;
		}

		return $db['permisos'];
	}
	
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Función para traer las alertas del usuario
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/ 
	
	
	function getAlertas()
	{
		if($this->_session_data['id_perfil'] == 1)
		{
			$db['alertas_user'] = $this->m_alertas->getAlertas($this->_session_data['id_usuario']);
		}else
		{
			$db['alertas_user'] = $this->m_alertas->getAlertas($this->_session_data['id_usuario'], $this->_session_data['id_ente']);
		}
		
		return $db['alertas_user'];	
	}


/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Función crear alertas
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/

	
	function alerta($alerta)
	{
		$session_data = $this->session->userdata('logged_in');
		
		$registro = array(
			'alerta'		=> $alerta,
			'id_usuario'	=> $session_data['id_usuario'],
			'id_ente'		=> $session_data['id_ente'],
			'visto'			=> 0
		);
		
		$this->m_alertas->insert($registro);
	}


/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Función para traer las alertas usuarios 999
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/


	function alerta_banco($alerta)
	{
		$bancos = $this->m_usuarios->getRegistros(1, 'id_perfil');
		
		if($bancos)
		{
			foreach ($bancos as $row) 
			{
				$registro = array(
					'alerta'		=> $alerta,
					'id_usuario'	=> $row->id_usuario,
					'visto'			=> 0
				);
				
				$this->m_alertas->insert($registro);
			}
		}
	}
	
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Función de exportación de tablas
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/	
	
	
	function armarExport()
	{
		$tabla = strip_tags($this->input->post('datos_a_enviar'), '<table><tr><td><th>');
		
		if($this->input->post('export') == 'pdf')
		{
			foreach ($this->input->post('cabeceras') as $cabecera) 
			{
				if($cabecera != 'Opciones')
				{
					$cabeceras[] = utf8_decode($cabecera);
				}
			}
			$this->armarPdf($tabla, $cabeceras);
		}else if($this->input->post('export') == 'excel')
		{
			$this->armarExcel($tabla);
		}else if($this->input->post('export') == 'print')
		{
			$this->armarPrint($tabla);
		}else
		{
			$post_data = $this->input->post(NULL, TRUE); 
			
			foreach ($post_data as $key => $value) 
			{
				log_message('ERROR', 'No entro el key => '.$key);
			}
		}
	}

	
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Exportación de tablas: Excel
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/


	function armarExcel($tabla)
	{
		header("Content-type: application/vnd.ms-excel; name='excel'; charset=UTF-8");
		header("Content-Disposition: filename=ficheroExcel.xls");
		header("Pragma: no-cache");
		header("Expires: 0");

		echo "\xEF\xBB\xBF";
        $tabla = str_replace("Opciones", "", $tabla);
		echo $tabla;
	}
	
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Exportación de tablas: Impresión
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/
	
	
	function armarPrint($tabla)
	{
	    $tabla = str_replace("Opciones", "", $tabla);
		$html = $tabla;
		$html .= '<script>';
        $html .= 'window.print();';
        $html .= 'setTimeout(window.close, 0);';
        $html .= '</script>';
        
        echo $html;
	}


/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Exportación de tablas: Pdf
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/

	
	function armarPdf($tabla, $cabeceras)
	{
		$dom = new DOMDocument();
		$doc = $dom->loadXml($tabla);
			
		$contador = 0;
			
		if(!empty($doc))
		{
			$dom->preserveWhiteSpace = false;                        // borramos los espacios en blanco 
			$tables  = $dom->getElementsByTagName('table');           // obtenemos el tag table
			$rows    = $tables->item(0)->getElementsByTagName('tr');    // array con todos los tr
			$i       = 0;                                                  // recorremos el array
				
			foreach ($rows as $row)
			{ 
				$cols = $row->getElementsByTagName('td');
					
				foreach ($cabeceras as $key => $value) 
				{
					if(isset($cols->item($key)->nodeValue) )
					{
						$registros[$i][$value] = $cols->item($key)->nodeValue;
					}else
					{
						$registros[$i][$value] = '-';
					}
				}
					
				$k = 0;
					
				foreach ($registros[$i] as $key => $value) 
				{
					if($value == '-' || $value == '')
					{
						$k = $k + 1;
					}
					
					if($k == count($registros[$i]))
					{
						unset($registros[$i]);
					}
				}
				$i = $i + 1;
			}
			
			// set HTTP response headers
		   	$data['title']		= 'Registros'; 
			$data['author']		= 'Admin';
			$data['content']	= $registros; 
				
			$this->load->view('plantilla/pdf', $data);
		}
	}


/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Funcion para enviar email
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/
 
 
    function emailAdmin($mensaje)
    {
		$emailConfig = array(
			'protocol'       => 'smtp',
			'smtp_host'      => '192.168.100.26',
			//'smtp_port' => '',
			'smtp_user'      => '',
			'smtp_pass'      => '',
			'charset'        => 'utf-8',
			'mailtype'       => 'html',
			'newline'        => '\\r\ ',
			'crlf'           => '\\r\ '
		);
        
		$this->load->library('email',$emailConfig);
		$this->email->set_newline('\\r\ ');

		$this->email->from($this->emailFrom, 'SRP');
		$this->email->to($this->emailTo); 
		
		$copy = '';
		foreach ($this->emailCopy as $email) 
		{
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
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Exportación de tablas: Impresión
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/
    
    
    function setLog($level, $log, $accion = NULL)
    {
        $registro = array(
            'id_nivel'  => $level,
            'log'       => $log,
            'programa'  => $this->config->item('programa')
        );
        
        if($accion != NULL)
        {
            $registro['accion'] = $accion;
        }
        
        $this->m_logs_usuarios->insert($registro);
    }   
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Exportación de tablas: Impresión
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/
    
    
    function getUnique()
    {
        $campo  = $this->input->post('campo');
        $valor  = $this->input->post('valor');
        $accion = $this->input->post('accion');
        $base   = $this->input->post('base');
        
        $where = array(
            $campo  => $valor,
        );
        
        $registros = $this->model->getRegistros($where);
        
        if($accion == 'agregar')
        {
            if($registros)
            {
                echo 0;
            } else 
            {
                echo 1;
            }    
        } else if($accion == 'modificar')
        {
            if($valor != $base && $registros)
            {
                echo 0;
            } else {
                echo 1;
            }    
        }
    }    
}