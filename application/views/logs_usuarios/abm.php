    <?php
/*--------------------------------------------------------------------------------  
            Comienzo del contenido
 --------------------------------------------------------------------------------*/ 

$html = startContent();

/*--------------------------------------------------------------------------------  
            Formulario
 --------------------------------------------------------------------------------*/ 

if($registro)
{  
    foreach ($registro as $row) 
    {
        $try_log = json_decode($row->log);
    
        if (json_last_error() === 0) 
        {
            $log = '';    
            foreach ($try_log as $key => $value) 
            {
                $log .= setTableContent(array($key, $value));
            }
        }else
        {
            $log = setTableContent(array('log', $row->log));
        }
        
        $try_registro = json_decode($row->registro);
    
        if (json_last_error() === 0 && is_array($try_registro)) 
        {
            $registro = '';   
            foreach ($try_registro as $key => $value) 
            {
                $registro .= setTableContent(array($key, $value));
            }    
        }else
        {
            if($row->registro != '')
            {
                $registro = setTableContent(array('ID', $row->registro));
            }else 
            {
                $registro = setTableContent(array('', ''));
            }
        }
        
        $html .= '<div class="row">';
        $html .= '<div class="col-sm-12 text-center">';
        $anterior = $id - 1;
        $siguiente = $id + 1;
        
        if($anterior > 0){
            $html .= '<a href="'.base_url().'index.php/'.$subjet.'/abm/'.$anterior.'" class="btn btn-default pull-left" style="margin-right: 5px;">'.lang('anterior').'</a>';    
        } else {
            $html .= '<a class="btn btn-default pull-left disabled" style="margin-right: 5px;">'.lang('anterior').'</a> ';
        }
        
        if($siguiente < $cantidad){
            $html .= '<a href="'.base_url().'index.php/'.$subjet.'/abm/'.$siguiente.'" class="btn btn-default pull-left">'.lang('siguiente').'</a> ';    
        } else {
            $html .= '<a class="btn btn-default pull-left disabled">'.lang('siguiente').'</a> ';
        }
        
        
        $html .= '<a href="'.base_url().'index.php/'.$subjet.'/table" class="btn btn-default pull-right ">'.lang('tabla').'</a> ';
        $html .= '</div><div class="col-sm-12 text-center">';
        $html .= '<h4>'.lang('programa').': ';
        $html .= $row->programa;
        $html .= '</h4>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<hr>';
          
    	$html .= '<div class="row">';
       
        $html .= '<div class="col-sm-3">';
        $html .= '<b>'.lang('datos').'</b>';
        $html .= startTable(NULL, NULL, 'table-striped'); 
        $html .= setTableContent(array('Accion', $row->accion));  
        $html .= setTableContent(array('Fecha', $row->date_add));
        $html .= setTableContent(array('Nivel', $row->nivel));
        $html .= setTableContent(array('Usuario', $row->user_add));
        $html .= setTableContent(array('Tabla', $row->tabla));
        $html .= endTable();
        $html .= '</div>';
        
        $html .= '<div class="col-sm-6">';
        $html .= '<b>'.lang('log').'</b>';
        $html .= startTable(NULL, NULL, 'table-striped');   
        $html .= $log;
        $html .= endTable();
        $html .= '</div>';
        
        $html .= '<div class="col-sm-3">';
        $html .= '<b>'.lang('registro').'</b>';
        $html .= startTable(NULL, NULL, 'table-striped');      
        $html .= $registro;
        $html .= endTable();
        $html .= '</div>';
        
        $html .= '</div>';
    } 
}

/*--------------------------------------------------------------------------------  
            Fin del contenido y js
 --------------------------------------------------------------------------------*/ 
 
$html .= endContent();

echo $html;
?>