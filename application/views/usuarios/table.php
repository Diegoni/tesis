<?php
/*--------------------------------------------------------------------------------  
            Comienzo del contenido
 --------------------------------------------------------------------------------*/
 
$cabeceras = array(
    lang('usuario'),
    lang('perfil'),
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
            $row->usuario,
            $row->perfil,
            tableUpd($subjet, $row->id_usuario),
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