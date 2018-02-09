<?php
/*--------------------------------------------------------------------------------  
            Comienzo del contenido
 --------------------------------------------------------------------------------*/
 
$cabeceras = array(
    lang('animal'),
    lang('marcacion'),
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

if($registros)
{
    foreach ($registros as $row) 
    {
    	$registro = array(
	        $row->id_animal,
	    	formatDatetime($row->marcacion_inicio),
		);

		
        $html .= setTableContent($registro);    
    }
}
            
$html .= endTable($cabeceras);     

$loading = loadingButton();	

$button = '<center>
		<form method="post" action="'.base_url().'index.php/tambos_caminos/cierre/">
		<button class="btn btn-app" data-loading-text="'.$loading['loading'].'" name="cierre" id="cierre" onclick="return confirm("Esta seguro de querer cerrar!")" type="submit" value="1">';
$button	.= '<i class="fa fa-close"></i>';
$button	.= lang('cierre');
$button	.= '</button></form></center>';
	
$button	.= $loading['script'];

$html .= $button;
    
$html .= setDatatables(NULL, array(1, "desc"));           

/*--------------------------------------------------------------------------------  
            Fin del contenido
 --------------------------------------------------------------------------------*/
 
$html .= endContent();

echo $html;
?>