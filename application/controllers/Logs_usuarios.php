<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logs_usuarios extends MY_Controller 
{
	protected $_subject = 'logs_usuarios';
    protected $_model   = 'm_logs_usuarios';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id)
    {                           
        $db['registro']     = $this->model->getRegistros($id);
        $db['id']           = $id;
        $db['cantidad']     = $this->model->getCantidad();
        
        
        $this->armarVista('abm', $db);
    }
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function ajax()
    {
        $json               = "";
        $registros = $this->model->getRegistros();
        
        if($registros){
            $url_modificar      = "'".base_url()."index.php/".$this->_subject."/abm/";
            $btn_class          = "'btn btn-default'";
            $icon_class         = "'fa fa-pencil-square-o'";
            foreach ($registros as $row) {
                $url_final = $row->id_log."'";
                
                $buttons = '<a class='.$btn_class.' href='.$url_modificar.$url_final.'><i class='.$icon_class.'></i></a> ';
                
                $registro = array(
                    $row->date_add,
                    $row->accion,
                    $row->user_add,
                    $row->programa,
                    $buttons,
                );
                    
                $json .= setJsonContent($registro);
            }
        }        
        
        $json = substr($json, 0, -2);
         
        echo '{ "data": ['.$json.' ]  }';
    }

    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Ver contenido del archivo
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/ 


    function backup()
    {
        if($this->input->post('backup'))
        {
            $this->load->dbutil();
            
            if($this->input->post('format') == 'txt')
            {
                $extencion = 'sql';    
            }else{
                $extencion = $this->input->post('format'); 
            }
            
            $prefs = array(
                'tables'        => $this->input->post('tablas'),    // Array of tables to backup.
                'ignore'        => array(),                         // List of tables to omit from the backup
                'format'        => $this->input->post('format'),    // gzip, zip, txt
                'filename'      => $this->input->post('name').'.'.$extencion,           // File name - NEEDED ONLY WITH ZIP FILES
                'add_drop'      => TRUE,                            // Whether to add DROP TABLE statements to backup file
                'add_insert'    => TRUE,                            // Whether to add INSERT data to backup file
                'newline'       => "\n"                             // Newline character used in backup file
            );

            // Backup your entire database and assign it to a variable
            $backup = $this->dbutil->backup($prefs);
            
            if($this->input->post('truncate'))
            {
                if(in_array('logs_usuarios', $prefs['tables']))
                {
                    $this->model->truncate();
                }   
            } 
    
            // Load the file helper and write the file to your server
            $this->load->helper('file');
            write_file('/path/to/'.$prefs['filename'], $backup);
    
            // Load the download helper and send the file to your desktop
            $this->load->helper('download');
            force_download($prefs['filename'], $backup);     
        }

        $db['tables'] = $this->db->list_tables();
        
        $this->armarVista('backup', $db);
    }
}    
?>