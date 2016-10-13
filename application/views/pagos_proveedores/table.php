<?php
/*--------------------------------------------------------------------------------  
            Comienzo del contenido
 --------------------------------------------------------------------------------*/
 
$cabeceras = array(
    lang('factura'),
    lang('forma_pago'),
    lang('total'),
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
        $registro = array(
            $row->nro_factura,
            $row->forma_pago,
            $row->total,
            tableUpd($subjet, $row->id_pago),
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