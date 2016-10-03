<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transacciones extends MY_Controller 
{
	protected $_subject = 'transacciones';
    protected $_model   = 'm_transacciones';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
        $this->load->model('m_transacciones_estados');
        $this->load->model('m_usuarios');
        $this->lang->load('error_transacciones', 'spanish');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/


    function conciliacion()
    {
        $db['transaccion'] = FALSE;
        $db['ingreso']     = ''; 
        
        if($this->input->post('transaccion')) {
            $log['ingreso']     = $this->input->post('transaccion');
            
            $transaccion        = $this->input->post('transaccion');
            $transaccion        = str_replace("-", "", $transaccion);
            $transaccion        = str_replace("_", "", $transaccion);
            $id_transaccion     = substr($transaccion, 0, -1);
            
            $control_id = $id_transaccion;
            if(strlen($id_transaccion) < 9){
                for ($i = strlen($id_transaccion); $i  < 9; $i ++) { 
                    $control_id = '0'.$control_id;
                }
            }
            
            $control_transaccion = $transaccion;
            if(strlen($transaccion) < 9){               
                for ($i = strlen($transaccion); $i  < 9; $i ++) { 
                    $control_transaccion = '0'.$control_transaccion;
                }
            }
            
            $digito_verficador  = digitoVerificador($control_id);
            
            if(strlen($transaccion) < 10){
                $db['ingreso'] = $transaccion;
                
                for ($i = strlen($transaccion); $i  < 10; $i ++) { 
                    $db['ingreso'] = '0'.$db['ingreso'];
                }
                $db['ingreso'] = substr($db['ingreso'], 0, 5).'-'.substr($db['ingreso'], 5);
            }else{
                $db['ingreso'] = substr($transaccion, 0, 5).'-'.substr($transaccion, 5);;
            }
            
            if($control_transaccion != $digito_verficador || $id_transaccion == '' ){
            
                $db['mensaje']      = lang('error_ingreso_caracteres').' : <b class="pull-right">'.$db['ingreso'].'</b>';
                $db['tipo_mensaje'] = 'danger';
                $log['respuesta']   = 'error digito verificador';
            } else {
                $transacciones = $this->model->getRegistros($id_transaccion);
                
                if(!$transacciones){
                    $db['mensaje']      = lang('error_transaccion_no_encontrada').' : <b class="pull-right">'.$db['ingreso'].'</b>';
                    $db['tipo_mensaje'] = 'danger';
                    $log['respuesta']   = 'error transaccion no encontrada';
                } else {
                    foreach ($transacciones as $row) {
                        if($row->id_estado == 2){
                            $db['mensaje']      = '<br>'.lang('error_transaccion_anulada').' : <b class="pull-right">'.$db['ingreso'].'</b>';
                            $db['mensaje']     .= '<br>Fecha de la anulación: <b class="pull-right">'.formatDate($row->date_upd).'</b>';
                            $db['mensaje']     .= '<br>Monto: <b class="pull-right">'.formatImporte($row->importe).'</b>';
                            $db['tipo_mensaje'] = 'warning';
                            $log['respuesta']   = 'error transaccion no encontrada';
                        } else if($row->id_estado == 3){
                            $db['mensaje']      = '<br>'.lang('error_transaccion_conciliada').' : <b class="pull-right">'.$db['ingreso'].' </b>';
                            $db['mensaje']     .= '<br>Fecha de la conciliación: <b class="pull-right">'.formatDate($row->date_upd).'</b>';
                            $db['mensaje']     .= '<br>Monto: <b class="pull-right">'.formatImporte($row->importe).'</b>';
                            $db['tipo_mensaje'] = 'warning';
                            $log['respuesta']   = 'advertencia transaccion conciliada';
                        } else {
                            $db['transaccion']  = (array) $row;
                            $log['respuesta']   = 'ok';
                        }
                    }
                }
            }
            
            $this->setLog(3, json_encode($log));   
            
        } else if($this->input->post('id_transaccion')){
            $registro = array(
                'importe_operacion' => $this->input->post('importe_operacion'),
                'comentario'        => $this->input->post('comentario'),
                'id_estado'         => 3,
            );
            
            $this->model->update($registro, $this->input->post('id_transaccion'));
            
            $db['mensaje']      = 'update_ok'; 
            $db['tipo_mensaje'] = 'success';           
            
            $this->setLog(3, 'Transaccion conciliada : '.$this->input->post('id_transaccion'));
        }

        $this->armarVista('conciliacion', $db);
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
            $url_modificar      = "'".base_url()."index.php/$this->_subject/abm/";
            $btn_class          = "'btn btn-default'";
            $icon_class         = "'fa fa-pencil-square-o'";
            foreach ($registros as $row) {
                $url_final = $row->id_transaccion."'";
                
                $buttons = '<a class='.$btn_class.' href='.$url_modificar.$url_final.'><i class='.$icon_class.'></i></a> ';
                
                if($row->id_estado == 1){
                    $estado = setSpan($row->estado, 'success');
                }else if($row->id_estado == 2){
                    $estado = setSpan($row->estado, 'danger');
                }else if($row->id_estado == 3){
                    $estado = setSpan($row->estado, 'primary');
                }
        
                $barra_interna = substr($row->barra_interna, 0, 5).'-'.substr($row->barra_interna, 5);
                
                $registro = array(
                    $barra_interna,
                    $row->transaccion,
                    formatImporte($row->importe),
                    $estado,
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
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/


    function abm($id)
    {
        if($this->input->post('transaccion')){
            $transaccion        = str_replace("-", "", $this->input->post('transaccion'));
            $transaccion        = str_replace("_", "", $transaccion);
            
            if(strlen($transaccion) < 10){
                for ($i = strlen($transaccion); $i  <  10; $i ++) { 
                    $transaccion = '0'.$transaccion;
                }
            }
            
            
            $where = array(
                'barra_interna' => $transaccion
            );
            
            $db['registros']    = $this->model->getRegistros($where);
            $db['transaccion']  = $transaccion;
        } else {
            $db['registros']    = $this->model->getRegistros($id);
            $db['transaccion']  = '-';    
        }
        
        $this->armarVista('abm', $db);
    }
    

/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/


    function estadisticas(){
        $this->load->library('Graficos');
        
        if($this->input->post('inicio')){
            $db['inicio']   = $this->input->post('inicio');
            $db['final']    = $this->input->post('final');
        } else {
            $db['inicio']   = date('Y/m/01');
            $db['final']    = date('Y/m/'.getUltimoDiaMes(date('Y/m')));
        }
        
        $db['registros']    = $this->model->getTransacciones($db['inicio'], $db['final']);
        $db['estados']      = $this->m_transacciones_estados->getRegistros();
        $db['usuarios']     = $this->m_usuarios->getRegistros();
        
        $this->armarVista('estadisticas', $db);
    }   
    
}
?>