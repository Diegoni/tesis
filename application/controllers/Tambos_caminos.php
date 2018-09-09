<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tambos_caminos extends MY_Controller 
{
	protected $_subject = 'tambos_caminos';
    protected $_model   = 'm_tambos_caminos';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');
		$this->load->model('m_animales');
		$this->load->model('m_animales_rutinas');
		$this->load->model('m_animales_marcaciones');
        $this->load->model('m_tambos_compuertas');
		$this->load->model('m_tambos_sectores');
		$this->load->model('m_tambos_caminos_detalles');
		
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)                         
    {
    	if($this->input->post('detalle'))
    	{
    		$registro = array(
    			'id_camino'	=> $this->input->post('id_camino'),
				'id_compuerta'	=> $this->input->post('id_camino'),
				'valor'	=> $this->input->post('valor'),
				'orden'	=> $this->input->post('orden'),
			);
			
    		$this->m_tambos_caminos_detalles->insert($registro);
			
    		$id_registro 		= $this->input->post('id_camino');
    		$db['id_registro']  = $id_registro;
            $db['detalles']     = $this->m_tambos_caminos_detalles->getRegistros($id_registro, 'id_camino');
            $db['caminos']      = $this->model->getRegistros($id_registro);
    		
    	}else if($id != NULL)
        {
            $db['id_registro']  = $id;
            $db['detalles']     = $this->m_tambos_caminos_detalles->getRegistros($id, 'id_camino');
            $db['caminos']      = $this->model->getRegistros($id);            
        }else
        {
            $db['id_registro']  = FALSE;            
            $db['detalles']     = FALSE;
            $db['caminos']      = FALSE;
        }
                                   
		$db['sectores']   	= $this->m_tambos_sectores->getRegistros();								   
        $db['compuertas']   = $this->m_tambos_compuertas->getRegistros(); 
        
        $this->armarVista('abm', $db);
    }


/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function procesar()                         
    {
        if($this->input->post('id_camino')  == -1)
        {
            $registro = array(
                'camino'    => $this->input->post('camino'),
                'inicio'    => $this->input->post('inicio'),
                'final'     => $this->input->post('final'),

            );
            
            $id_camino = $this->model->insert($registro);
        }else
        {
            $id_camino = $this->input->post('id_camino');
            
            $registro = array(
                'camino'    => $this->input->post('camino'),
                'inicio'    => $this->input->post('incio'),
                'final'     => $this->input->post('final'),
            );
            
            $this->model->update($registro, $id_camino);
        }
        
        $this->table();
    }  


/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Animalees en camino
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/ 

	
	function en_proceso($id_camino)
	{
		$db['caminos']      = $this->model->getRegistros($id_camino);      
		$db['registros'] = $this->m_animales_marcaciones->getRegistros('0000-00-00 00:00:00', 'marcacion_final');
				
		$this->armarVista('en_proceso', $db);
	}

/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Cerrar circuito 
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/ 

	
	function cierre()
	{
		// Marco las finales
		$registro = array(
			'marcacion_final' 	=> date('Y-m-d H:i:s'),
			'comentario'		=> 'Cierre forzado'
		);
		
		$where = array(
			'marcacion_final' => '0000-00-00 00:00:00',
		);
								
		$this->m_animales_marcaciones->update($registro, $where);
		
		
		$registro = array(
			'en_proceso'	=> 0,
		);
							
		$where = array(
			'en_proceso'	=> 1,
		);
													
		$this->model->update($registro, $where);
		
		redirect('tambos_caminos/table/', 'refresh');							
	}


/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function getCamino($tarjeta = NULL, $inicio = NULL)                         
    {
    	$debug = FALSE;
		
		log_message('DEBUG', 'Lectura tarjeta '.$tarjeta);
		log_message('DEBUG', 'Lectura compuer '.$inicio);
		
		
    	if($tarjeta != NULL)
    	{
    		$animales = $this->m_animales->getRegistros($tarjeta, 'tarjeta'); 
			
			if($animales)
			{
				foreach ($animales as $animal) 
				{
					$id_animal = $animal->id_animal;
				}
				
				// Buscamos si hay una marcacion activas 
				$activos = $this->m_animales_marcaciones->getRegistros('0000-00-00 00:00:00', 'marcacion_final');
				
				$marcacion_inicial = TRUE;
				$abiertos = 0;
				
				if($activos)
				{
					if($debug)
					{
						echo 'Hay marcaciones abierta <br>';
					}
					
					foreach ($activos as $row_activo) 
					{
						if($row_activo->id_animal == $id_animal)
						{
							$marcacion_inicial = FALSE;
							
							// Obtengo de la rutina en que sector debe estar el animal
							$datos = array(
								'id_animal' => $id_animal,
								'id_sector' => $inicio, 
								'hora'		=> date('H:i:s'),
								'dia'		=> date('w'),
							);
							
							$id_sector = $this->m_animales_rutinas->getSector($datos);
							
							if($datos['id_sector'] == $id_sector)
							{
								$registro = array(
									'marcacion_final' => date('Y-m-d H:i:s'),
								);
								
								$this->m_animales_marcaciones->update($registro, $row_activo->id_marcacion);
								
								if($debug)
								{
									echo 'Se actualizo en db la marcacion final <br>';
								}								
							}else
							{
								$return = 'ERROR: Sector final '.$id_sector.' Lectura de la tarjeta en sector '.$inicio.'<br>';
							}
						}else
						{
							$abiertos = $abiertos + 1;
						}
					}

					if($debug)
					{
						echo 'Marcaciones abiertas '.$abiertos.' <br>';
					}	
				}
				
				if($marcacion_inicial)
				{
					if($debug)
					{
						echo 'Es una marcacion inicial <br>';
					}	
					
					// Obtengo el camino en proceso, para no permitir mas de un camino a la vez
					if($abiertos > 0)
					{
						$_en_proceso = $this->model->getRegistros('1', 'en_proceso');
					
						if($_en_proceso)
						{
							foreach ($_en_proceso as $row_en_proceso) 
							{
								$camino_en_proceso = $row_en_proceso->id_camino;
							}
						}
					}else
					{
						$camino_en_proceso = 0;
					}
					
					if($debug)
					{
						echo 'Camino en proceso '.$camino_en_proceso.'<br>';
					}
					
					// Obtengo de la rutina en que sector debe estar el animal
					$datos = array(
						'id_animal' => $id_animal,
						'id_sector' => $inicio, 
						'hora'		=> date('H:i:s'),
						'dia'		=> date('w'),
					);
					
					$id_sector = $this->m_animales_rutinas->getSector($datos);
					
					
					if($id_sector)
					{
						// Si el sector no es donde debe estar
						if($datos['id_sector'] != $id_sector)
						{
							// Busco el camino para ir desde el sector donde esta hasta el sector donde deberia
							$caminos = $this->model->getCamino($datos['id_sector'], $id_sector);
							
							if($caminos)
							{
								foreach ($caminos as $camino) 
								{
									$id_camino = $camino->id_camino;
								}
								
								// No hay camino en proceso
								if($camino_en_proceso == 0)
								{
									// Actualizaos la base de datos para ponerlo en proceso
									$registro = array(
										'en_proceso'	=> 1,
									);
										
									$this->model->update($registro, $id_camino);
									
									if($debug)
									{
										echo 'Camino abierto id '.$id_camino.'<br>';
									}
								}else
								{
									if($debug)
									{
										echo 'Se inteta hacer el camino '.$id_camino.'<br>';
									}
									
									// No permitimos el ingreso
									if($id_camino != $camino_en_proceso)
									{
										$return = 'ERROR: hay otro camino en ejecucion';
									}
								}
								
								if(!isset($return))
								{
									// Buscamos el detalle del camino
									$detalles = $this->m_tambos_caminos_detalles->getRegistros($id_camino, 'id_camino');
								
									if($detalles)
									{
										$registro = array(
											'id_animal'	=> $id_animal,
		  									'id_camino' => $id_camino,
		  									'marcacion_inicio' => date('Y-m-d H:i:s'),
										);
										
										$this->m_animales_marcaciones->insert($registro);
										
										$return = '';
										
										foreach ($detalles as $row_detalle) 
										{
											if($row_detalle->id_compuerta == 7 || $row_detalle->id_compuerta == 8)
											{
												if(strlen($row_detalle->valor) == 3)
												{
													$_cad = $row_detalle->valor;
												}else if(strlen($row_detalle->valor) == 2)
												{
													$_cad = '0'.$row_detalle->valor;
												}else
												{
													$_cad = '00'.$row_detalle->valor;
												}
											}else
											{
												$_cad = $row_detalle->id_compuerta;
											}
											
											$return .= $_cad.'-';
										}
										
										$return = substr($return, 0, -1);
									}else
									{
										$return = 'ERROR: no hay detalle de camino';
									}
								}
								
							}else
							{
								$return = "ERROR: No existe camino desde el sector ".$datos['id_sector']." a ".$id_sector;
							}	
						}else
						{
							$return = "ERROR: El animal debe permanecer en el sector";
						}
					}else
					{
						if($debug)
						{
							foreach ($datos as $key => $value) 
							{
								echo $key.' => '.$value.'<br>';
							}
						}
						
						$return = "ERROR: No hay un sector asignado para el animal en este horario";
					}
				}else
				{
					if(!isset($return))
					{
						$return = '';
					
						// Fue el ultimo animal en llegar, entonces sacamos la bandera en proceso
						if($abiertos == 0)
						{
							$registro = array(
								'en_proceso'	=> 0,
							);
							
							$where = array(
								'en_proceso'	=> 1,
							);
													
							$this->model->update($registro, $where);
							
							$return = "CCC";
						}	
					}else
					{
						if($debug)
						{
							echo 'Existe un return no se cambia el dato en_proceso<br>';
						}
					}
				}		
				
			}else{
				$return = "ERROR: No hay animal asociado a la tarjeta";
			}
    	}else{
    		$return = "ERROR: la tarjeta no fue enviada";
    	}
    	
		echo $return;
	}  
}
?>