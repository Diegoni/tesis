<?php
$html = '<script src="'.base_url().'librerias/multiselect/js/jquery.multi-select.js"></script>';
$html .= '<link href="'.base_url().'librerias/multiselect/css/multi-select.css" rel="stylesheet">';
$html .= setCss('plugins/bootstrap-switch-master/dist/css/bootstrap3/bootstrap-switch.css');
$html .= setJs('plugins/bootstrap-switch-master/dist/js/bootstrap-switch.js');

/*--------------------------------------------------------------------------------  
            Comienzo del contenido
 --------------------------------------------------------------------------------*/ 

$html .= startContent();

/*--------------------------------------------------------------------------------  
            Formulario
 --------------------------------------------------------------------------------*/ 
 
$html .= '<form method="post" action="'.base_url().'index.php/'.$subjet.'/backup/">';
$html .= '<div class="row divider">';
$html .= '<div class="col-md-2">';
$html .= lang('tablas');
$html .= '</div>';
$html .= '<div class="col-md-9">';
$html .= '<div class="pull-left">Sin seleccionar</div>';
$html .= '<div class="pull-right">Seleccionados</div>';
$html .= '<br>';
$html .= '<select class="form-control" name="tablas[]" id="tablas" multiple required/>';
foreach ($tables as $tabla) {
    $html .= '<option value="'.$tabla.'" selected>'.$tabla.'</option>';
}
$html .= '</select>';
$html .= '</div>';
$html .= '<div class="col-md-1">';
$html .= '<button type="button" class="btn btn-default" id="select-all"><i class="fa fa-arrow-right"></i></button>';
$html .= '<button type="button" class="btn btn-default divider" id="deselect-all"><i class="fa fa-arrow-left"></i></button>';
$html .= '</div>';
$html .= '</div>';

$html .= '<div class="row divider">';
$html .= '<div class="col-md-2">';
$html .= lang('nombre').' '.lang('archivo');
$html .= '</div>';
$html .= '<div class="col-md-4">';
$html .= '<input '.completarTag('name', date('Y-m-d').'-dump', 'onlyCharInt').'>';
$html .= '</div>';
$html .= '</div>';

$html .= '<div class="row divider">';
$html .= '<div class="col-md-2">';
$html .= lang('formato');
$html .= '</div>';
$html .= '<div class="col-md-4">';
$html .= '<select class="form-control" name="format" id="format" required/>';
$html .= '<option value="txt">sql</value>';
$html .= '<option value="gzip">gzip</value>';
$html .= '<option value="zip">zip</value>';
$html .= '</select>';
$html .= '</div>';
$html .= '</div>';

$html .= '<div class="row divider">';
$html .= '<div class="col-md-2">';
$html .= lang('eliminar').' '.lang('log');
$html .= '</div>';
$html .= '<div class="col-md-4">';
$html .= '<input type="checkbox" class="checkbox" name="truncate" checked>';
$html .= '</div>';
$html .= '</div>';

$html .= '<div class="row divider">';
$html .= '<div class="col-md-4"></div>';
$html .= '<div class="col-md-4">';
$html .= '<button class="btn btn-default form-control" type="submit" name="backup" value="1"><icon class="fa fa-download"></icon> '.lang('backup').'</button>';
$html .= '</div>';
$html .= '<div class="col-md-4"></div>';
$html .= '</div>';

$html .= '</form>';

/*--------------------------------------------------------------------------------  
            Fin del contenido y js
 --------------------------------------------------------------------------------*/ 
 
$html .= endContent();

echo $html;
?>
<script>
$('#tablas').multiSelect();
    
$('#select-all').click(function()
{
    $('#tablas').multiSelect('select_all');
    $('#tablas').multiSelect('refresh');
    return false;
});
        
$('#deselect-all').click(function()
{
    $('#tablas').multiSelect('deselect_all');
    $('#tablas').multiSelect('refresh');
    return false;
});

$(".checkbox").bootstrapSwitch();
</script>