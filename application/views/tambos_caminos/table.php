<?php
/*--------------------------------------------------------------------------------  
            Comienzo del contenido
 --------------------------------------------------------------------------------*/
 
$cabeceras = array(
    lang('camino'),
    lang('en_proceso'),
    lang('opciones'), 
);

$html = startContent();

if(isset($mensaje)){
    $html .= setMensaje($mensaje);
}

/*--------------------------------------------------------------------------------  
            Tabla
 --------------------------------------------------------------------------------*/

if($permiso_editar == 1)
{
    $html .= getExportsButtons($cabeceras, tableAdd($subjet));    
}else
{
    $html .= getExportsButtons($cabeceras);
}

$html .= startTable($cabeceras);

if($registros)
{
    foreach ($registros as $row) 
    {
    	if($row->en_proceso > 0)
    	{
    		$registro = array(
	            $row->camino,
	            setSpan($row->en_proceso),
	            tableButton($subjet.'/en_proceso', $row->id_camino, 'fa fa-eye'),
	        );
			
			$_date_upd = $row->date_upd;
			$_date_now = date('Y-m-d H:i:s');
			
			$minutos = ceil((strtotime($_date_now) - strtotime($_date_upd)) / 60);
			
			if ($minutos > 5) {
				$error_minutos = 'Animales fuera del rango de tiempo permitido, '.$minutos.' minutos de retraso';
				$html .= setMensaje($error_minutos);
			}
    	}else
    	{
    		$registro = array(
	            $row->camino,
	            '',
	            tableUpd($subjet, $row->id_camino),
	        );
    	}
		
        $html .= setTableContent($registro);    
    }
}
            
$html .= endTable($cabeceras);         
$html .= setDatatables(NULL, array(1, "desc"));           

/*--------------------------------------------------------------------------------  
            Fin del contenido
 --------------------------------------------------------------------------------*/
 
$html .= endContent();

echo $html;
?>