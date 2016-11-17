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
        $compuertas   = $this->m_tambos_compuertas->getRegistros();
        
        if($this->input->post('id_camino')  == -1)
        {
            $registro = array(
                'camino'    => $this->input->post('camino'),
                'inicio'    => 'inicio',
                'final'     => 'final',
            );
            
            $id_camino = $this->model->insert($registro);
            
            foreach ($compuertas as $compuerta) 
            {
                $registro = array(
                    'id_camino'     => $id_camino,
                    'id_compuerta'  => $compuerta->id_compuerta,
                    'id_estado'     => $this->input->post('com_'.$compuerta->id_compuerta),  
                );
                
                $this->m_tambos_caminos_detalles->insert($registro);             
            } 
        }else
        {
            $id_camino = $this->input->post('id_camino');
            
            $registro = array(
                'camino'     => $this->input->post('camino'), 
            );
            
            $this->model->update($registro, $id_camino);
            
            foreach ($compuertas as $compuerta) 
            {
                $registro = array(
                    'id_estado'     => $this->input->post('com_'.$compuerta->id_compuerta),  
                );
                
                $where = array(
                    'id_camino'     => $id_camino,
                    'id_compuerta'  => $compuerta->id_compuerta,
                );
                
                $this->m_tambos_caminos_detalles->update($registro, $where);             
            } 
        }
        
        $this->table();
    }    
}
?>