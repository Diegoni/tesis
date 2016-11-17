<?php
$html = setCss('plugins/bootstrap-switch-master/dist/css/bootstrap3/bootstrap-switch.css');
$html .= setJs('plugins/bootstrap-switch-master/dist/js/bootstrap-switch.js');


/*--------------------------------------------------------------------------------  
            Comienzo del contenido
 --------------------------------------------------------------------------------*/ 

$html .= startContent();

if(isset($mensaje))
{
    $html .= setMensaje($mensaje);
}

/*--------------------------------------------------------------------------------  
            Formulario
 --------------------------------------------------------------------------------*/ 
 
if($detalles)
{
    foreach ($detalles as $detalle) 
    {
        $id_compuertas[] = $detalle->id_compuerta;  
        if($detalle->id_estado == 1)
        {
            $estados[$detalle->id_compuerta] =    
            '<option value="1" selected><i class="fa fa-ban"></i> Cerrada</option>
             <option value="2"><i class="fa fa-check"></i> Abierta</option>';  
        }else if($detalle->id_estado == 2)
        {
             $estados[$detalle->id_compuerta] =    
            '<option value="1"><i class="fa fa-ban"></i> Cerrada</option>
             <option value="2" selected><i class="fa fa-check"></i> Abierta</option>';  
        }
    }    
}else
{
    $id_compuertas[] = array();
} 
 
 
$option = '<option value="1"><i class="fa fa-ban"></i> Cerrada</option>
             <option value="2"><i class="fa fa-check"></i> Abierta</option>';

$option_sector = '<option value="3"><i class="fa fa-play"></i> Inicio</option>
				<option value="4"><i class="fa fa-map-marker"></i> Final</option>';
 
$html .= '<form action="'.base_url().'index.php/tambos_caminos/procesar/" method="post" class="form-horizontal">';

$html .= '<div class="form-group">';
$html .= setLabel(lang('camino'), 2);
$html .= '<div class="col-sm-8">';

if($caminos)
{
    foreach ($caminos as $camino) 
    {
        $_camino = $camino->camino;     
    }
}else
{
    $_camino = '';
}

$html .= '<input '.completarTag('camino', $_camino).'>';
$html .= '</div>';
$html .= '</div>';

foreach ($compuertas as $compuerta) 
{
	$html .= '<div class="form-group">';
	$html .= setLabel($compuerta->compuerta, 2);
	
	$html .= '<div class="col-sm-8">';
	$html .= '<select name="com_'.$compuerta->id_compuerta.'" id="'.$compuerta->compuerta.'" class="select2 form-control">';
    
    if(in_array($compuerta->id_compuerta, $id_compuertas))
    {
        $html .= $estados[$compuerta->id_compuerta];
    }else
    {
        $html .= $option;    
    }    
    
	if($compuerta->id_sector != 0)
	{
	    $html .= $option_sector;    
	}
    
    $html .= '</select>';
	$html .= '</div>';
	$html .= '<div class="col-sm-2"></div>';
	$html .= '</div>';
}

$html .= '<div class="form-group">';
$html .= '<div class="col-md-12 text-center">';

if($id_registro)
{
    $html .= '<input type="hidden" name="id_camino" value="'.$id_registro.'">';
    $html .= btnUpd();    
}else
{
    $html .= '<input type="hidden" name="id_camino" value="-1">';
    $html .= btnAdd();    
}



$html .= '</div>';
$html .= '</div>';

$html .= '</form>';


/*--------------------------------------------------------------------------------  
            Fin del contenido y js
 --------------------------------------------------------------------------------*/ 
 
$html .= endContent();

echo $html;
?>

<script>
$("[data-inputmask]").inputmask();
$(".checkbox").bootstrapSwitch();
</script>
