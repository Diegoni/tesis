<?php
/*--------------------------------------------------------------------------------  
            Comienzo del contenido
 --------------------------------------------------------------------------------*/
 
$cabeceras = array(
    lang('tipo'),
    lang('sector'),
    lang('dia'),
    lang('inicio'),
    lang('final'),
    lang('opciones'), 
);

$html = startContent();

if(isset($mensaje)){
    $html .= setMensaje($mensaje);
}

/*--------------------------------------------------------------------------------  
            Tabla
 --------------------------------------------------------------------------------*/

if($permiso_editar == 1){
    $html .= getExportsButtons($cabeceras, tableAdd($subjet));    
}else{
    $html .= getExportsButtons($cabeceras);
}

$html .= startTable($cabeceras);

if($registros){
    foreach ($registros as $row) {
        $registro = array(
            $row->tipo,
            $row->sector,
            $row->dia,
            $row->inicio,
            $row->final,
            tableUpd($subjet, $row->id_rutina   ),
        );
        
        $html .= setTableContent($registro);    
    }
}
            
$html .= endTable($cabeceras);         
$html .= setDatatables();           

/*--------------------------------------------------------------------------------  
            Fin del contenido
 --------------------------------------------------------------------------------*/
 
$html .= endContent();

echo $html;
?>