<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('m_usuarios');
        $this->load->model('m_usuarios_permisos');   	
        $this->load->model('m_logs_usuarios');
	}


/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Login: carga de pantalla de login
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   


	function index()
	{
		if($this->session->userdata('logged_in')){
		    redirect('/home/','refresh');
		}else{
			$this->load->view('plantilla/head');
			$this->load->view('login/inicio');
		}
	}
    

/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Login: log out
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/       


	function logout()
	{
		 $registro = array(
            'id_nivel'  => '3',
            'log'       => 'logout',
            'accion'    => 'logout',
            'programa'  => $this->config->item('programa')
        );
            
        $this->m_logs_usuarios->insert($registro);
        
		$this->session->unset_userdata('logged_in');
        session_destroy();
	  	$this->index();
	}


/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Login: control de datos usuario y pass
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/  

	
	function control()
	{
		$username  = $this->input->post('username');
        $password  = $this->input->post('password');
		
	  	$usuario = $this->checkDatabase($username, $password);
	   
	   	if($usuario != 1){
	   		if($usuario == 0){
	   			$db['error'] = $this->lang->line('usuario_incorrecto');
	   		} else {
	   		    $registro = array(
                    'level' => '2',
                    'log'   => 'Usuario '.$username.' esta intentendo hacer log in'
                );
                $this->m_logs_usuarios->insert($registro);
	   			$db['error'] = $this->lang->line('usuario_baja');
			}
		   
		    $this->load->view('plantilla/head.php', $db);
			$this->load->view('login/inicio');
	   	} else {
	   		$session_data        = $this->session->userdata('logged_in');
            
            $this->load->library('user_agent');
            if ($this->agent->is_browser()){
                $agent = $this->agent->browser();
            }else if ($this->agent->is_robot()){
                $agent = $this->agent->robot();
            }else if ($this->agent->is_mobile()) {
                $agent = $this->agent->mobile();
            } else {
                $agent = 'Unidentified User Agent';
            }
        
            $log = array(
                'usuario'       => $session_data['usuario'],
                'ip'            => $this->input->ip_address(),
                'navegador'     => $agent,
                'sistema'       => $this->agent->platform(),
            );
            
            $registro = array(
                'id_nivel'  => '3',
                'log'       => json_encode($log),
                'accion'    => 'login',
                'programa'  => $this->config->item('programa')
            );
            
			$this->m_logs_usuarios->insert($registro);
            
            redirect('/animales/table/','refresh');    
	  	}
	}
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Login: inicio de de session 
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/  


	function checkDatabase($username, $password)
	{
		$result = $this->m_usuarios->login($username, $password);
	
		if($result){
		    foreach($result as $row){
				$sess_array = array(
				    'id_usuario'   => $row->id_usuario,
				    'usuario' 	   => $row->usuario,
					'id_rol'	   => $row->id_perfil,
					'last_login'   => $row->last_login,
					'nombre'       => $row->nombre,
					'apellido'     => $row->apellido,
					'eliminado'    => $row->eliminado,
		    	);
			}
            
            if($sess_array['eliminado'] == 0)
            {
                $menu = $this->m_usuarios_permisos->getMenu($sess_array['id_rol']);
                
                if($menu)
                {
                    foreach ($menu as $row_menu) 
                    {
                        $permisos[] = array(
                            'menu'      => $row_menu->menu,
                            'url'       => $row_menu->url,
                            'ver'       => $row_menu->ver,
                            'editar'    => $row_menu->editar,
                            'icon'      => $row_menu->icon,
                            'id_padre'  => $row_menu->id_padre,
                            'id_permiso'=> $row_menu->id_permiso,
                        );
                    }   
                    
                     $sess_array['permisos'] = $permisos; 
                }

				$ci = & get_instance(); 
				$this->session->unset_userdata('logged_in');
				$this->session->set_userdata('logged_in', $sess_array);
			    
				return 1;
			}else{
				return 2;
			}
		
		} else {
			return 0;
		}
	}
}
?>