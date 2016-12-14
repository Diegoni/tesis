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
        $this->load->model('m_tambos_compuertas');
        $this->load->model('m_tambos_caminos_detalles');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)                         
    {
        if($id != NULL)
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
                'servo_uno' => $this->input->post('servo_uno'),
                'servo_dos' => $this->input->post('servo_dos'),
            );
            
            $id_camino = $this->model->insert($registro);
        }else
        {
            $id_camino = $this->input->post('id_camino');
            
            $registro = array(
                'camino'    => $this->input->post('camino'),
                'inicio'    => $this->input->post('incio'),
                'final'     => $this->input->post('final'),
                'servo_uno' => $this->input->post('servo_uno'),
                'servo_dos' => $this->input->post('servo_dos'),
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
    
    
    function getCamino($tarjeta = NULL)                         
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
				
				$datos = array(
					'id_animal' => $id_animal,
					'id_sector' => '1', // porque solo tengo un solo lector de rfid
					'hora'		=> date('H:i:s'),
					'dia'		=> date('w'),
				);
				
				$id_sector = $this->m_animales_rutinas->getSector($datos);
				
				// Si el sector no es donde debe estar
				
				if($id_sector)
				{
					if($datos['id_sector'] != $id_sector)
					{
						$caminos = $this->model->getCamino($datos['id_sector'], $id_sector);
						
						if($caminos)
						{
							foreach ($caminos as $camino) 
							{
								if(strlen($camino->servo_uno) < 3)
								{
									$servo_uno = $camino->servo_uno;
									
									for ($i=strlen($camino->servo_uno); $i < 3; $i++) 
									{ 
										$servo_uno = '0'.$servo_uno;
									}
								}
								
								if(strlen($camino->servo_dos) < 3)
								{
									$servo_dos = $camino->servo_dos;
									
									for ($i=strlen($camino->servo_dos); $i < 3; $i++) 
									{ 
										$servo_dos = '0'.$servo_dos;
									}
								}
								
								$return = $servo_uno.',';
								$return .= $servo_dos.',';
								$return .= $camino->inicio.',';
								$return .= $camino->final;
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