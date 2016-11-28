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
 
$_option = '';
foreach ($compuertas as $compuerta) 
{
    $_option .= '<option value="'.$compuerta->id_compuerta.'">'.$compuerta->compuerta.'</option>';
}

if($caminos)
{
    foreach ($caminos as $camino) 
    {
        $_camino = $camino->camino;   
		$_servo_uno = $camino->servo_uno;   
		$_servo_dos = $camino->servo_dos;     
    }
}else
{
    $_camino = '';
	$_servo_uno = '';   
	$_servo_dos = '';    
}

 
$html .= '<form action="'.base_url().'index.php/tambos_caminos/procesar/" method="post" class="form-horizontal">';

$html .= '<div class="form-group">';
$html .= setLabel(lang('camino'), 2);
$html .= '<div class="col-sm-8">';
$html .= '<input '.completarTag('camino', $_camino).'>';
$html .= '</div>';
$html .= '</div>';


$html .= '<div class="form-group">';
$html .= setLabel(lang('inicio'), 2);
$html .= '<div class="col-sm-8">';
$html .= '<select name="inicio" id="inicio" class="select2 form-control">';
$html .= $_option;
$html .= '</select>';
$html .= '</div>';
$html .= '</div>';


$html .= '<div class="form-group">';
$html .= setLabel(lang('final'), 2);
$html .= '<div class="col-sm-8">';
$html .= '<select name="final" id="final" class="select2 form-control">';
$html .= $_option;
$html .= '</select>';
$html .= '</div>';
$html .= '</div>';


$html .= '<div class="form-group">';
$html .= setLabel(lang('servo_uno'), 2);
$html .= '<div class="col-sm-8">';
$html .= '<input '.completarTag('servo_uno', $_servo_uno).'>';
$html .= '</div>';
$html .= '</div>';


$html .= '<div class="form-group">';
$html .= setLabel(lang('servo_dos'), 2);
$html .= '<div class="col-sm-8">';
$html .= '<input '.completarTag('servo_dos', $_servo_dos).'>';
$html .= '</div>';
$html .= '</div>';

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
