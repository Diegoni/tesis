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
 
$option = '<option value="1"><i class="fa fa-ban"></i> Cerrada</option>
			<option value="2"><i class="fa fa-check"></i> Abierta</option>';
$option_sector = '<option value="3"><i class="fa fa-play"></i> Inicio</option>
				<option value="4"><i class="fa fa-map-marker"></i> Final</option>';
 
$html .= '<form action="#" method="post" class="form-horizontal">';

foreach ($compuertas as $compuerta) 
{
	$html .= '<div class="form-group">';
	$html .= setLabel($compuerta->compuerta, 2);
	
	$html .= '<div class="col-sm-8">';
	$html .= '<select name="'.$compuerta->compuerta.'" id="'.$compuerta->compuerta.'" class="select2 form-control">';
    $html .= $option;
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
$html .= btnAdd();
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
