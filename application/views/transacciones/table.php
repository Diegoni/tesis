<?php
/*--------------------------------------------------------------------------------  
            Comienzo del contenido
 --------------------------------------------------------------------------------*/
 
$cabeceras = array(
    lang('barra'),
    lang('transaccion'),
    lang('importe'),
    lang('estado'),
    lang('opciones'),
);

$html = startContent();

if(isset($mensaje)){
    $html .= setMensaje($mensaje);
}

/*--------------------------------------------------------------------------------  
            Tabla
 --------------------------------------------------------------------------------*/
 
$html .= getExportsButtons($cabeceras);

$html .= startTable($cabeceras);        
$html .= endTable($cabeceras);  
            
$html .= setDatatables(NULL, 0, base_url().'index.php/'.$subjet.'/ajax');   

/*--------------------------------------------------------------------------------  
            Fin del contenido
 --------------------------------------------------------------------------------*/
 
$html .= endContent();

echo $html;
?>