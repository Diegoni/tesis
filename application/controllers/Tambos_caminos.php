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
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function getCamino($tarjeta = NULL, $inicio = NULL)                         
    {
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
				
				if($activos)
				{
					$abiertos = 0;
					
					foreach ($activos as $row_activo) 
					{
						if($row_activo->id_animal == $id_animal)
						{
							$registro = array(
								'marcacion_final' => date('Y-m-d H:i:s'),
							);
							
							$this->m_animales_marcaciones->update($registro, $row_activo->id_marcacion);
							$marcacion_inicial = FALSE;
						}else
						{
							$abiertos = $abiertos + 1;
						}
					}
				}
				
				if($marcacion_inicial)
				{
					$datos = array(
						'id_animal' => $id_animal,
						'id_sector' => $inicio, // porque solo tengo un solo lector de rfid
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
								
								$camino_en_proceso = $this->model->getRegistros(1, 'en_proceso');
								
								//Si ya hay un camino en proceso, verifico que sea el mismo
								if($camino_en_proceso)
								{
									foreach ($camino_en_proceso as $camino) 
									{
										$id_camino_en_proceso = $camino->id_camino;
									}
									
									if($id_camino_en_proceso != $id_camino)
									{
										$return = 'ERROR: hay otro camino en proceso';
									}
								// Si no hay camino en proceso lo marco en proceso	
								}else
								{
									$registro = array(
										'en_proceso'	=> 1,
									);
									
									$this->model->update($registro, $id_camino);
								}
								
								
								
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
										$return .= $row_detalle->id_compuerta.'_'.$row_detalle->valor.'&';
									}
									
									$return = substr($return, 0, -1);
								}else
								{
									$return = 'ERROR: no hay detalle de camino';
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
						$return = "ERROR: No hay un sector asignado para el animal en este horario";
					}
				}else
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