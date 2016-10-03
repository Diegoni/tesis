<?php
$html = '<section class="content">';

$html .= '<div class="row">';

$html .= '<section class="col-md-12">';
$html .= '<div class="box box-info">';
$html .= '<div class="box-body">';
$html .= '<form class="form-horizontal" method="post" action="'.base_url().'index.php/'.$subjet.'/estadisticas/">';

$html .= '<div class="col-sm-2">';
$html .= '<label for="inicio" class="col-sm-2 control-label">'.lang('fecha').'</label>';
$html .= '</div>';


$html .= '<div class="col-sm-4">';
$javascrit = "$('#inicio').focus()";
$html .= '<div class="input-group" onclick="'.$javascrit.'">';
$html .= '<input '.completarTag('inicio', $inicio, 'false', 'datepicker_start').' >';
$html .= '<div class="input-group-addon"><icon class="fa fa-calendar"></icon></div>';
$html .= '</div>';
$html .= '</div>';

$html .= '<div class="col-sm-4">';
$javascrit = "$('#final').focus()";
$html .= '<div class="input-group" onclick="'.$javascrit.'">';
$html .= '<input '.completarTag('final', $final, 'false', 'datepicker_end').' >';
$html .= '<div class="input-group-addon"><icon class="fa fa-calendar"></icon></div>';
$html .= '</div>';
$html .= '</div>';

$html .= '<div class="col-sm-2">';
$html .= '<button class="btn btn-default form-control"><icon class="fa fa-search"></icon> '.lang('buscar').'</button>';
$html .= '</div>';

$html .= '</form>';
$html .= '</div>';
$html .= '</div>';
$html .= '</section>';

$html .= '</div>';


/*--------------------------------------------------------------------------------	
 			Graficos Lotes
 --------------------------------------------------------------------------------*/
$html .= '<div class="row">';

$html .= '<section class="col-md-12">';
$html .= setGraficoDiv('id_barra', '0');;
$html .= '</section>';

$html .= '</div>';

/*--------------------------------------------------------------------------------  
            Graficos Lotes
 --------------------------------------------------------------------------------*/
$html .= '<div class="row">';

$html .= '<section class="col-md-6">';
$html .= setGraficoDiv('id_torta', '0');;
$html .= '</section>';

$html .= '<section class="col-md-6">';
$html .= setGraficoDiv('id_usuarios', '0');;
$html .= '</section>';

$html .= '</div>';

/*--------------------------------------------------------------------------------	
 --------------------------------------------------------------------------------
 			Datos Graficos
 --------------------------------------------------------------------------------
 --------------------------------------------------------------------------------*/

$graficos = new Graficos();

$opcion_barra = array(
	'id' 	=> 'id_barra',
	'title' => 'Total de las transacciones',
	'type'	=> 'line',
);

$opcion_torta = array(
    'id'    => 'id_torta',
    'title' => 'Transacciones por estado',
    'type'  => 'legend',
);

$opcion_usuarios = array(
    'id'    => 'id_usuarios',
    'title' => 'Cantidad por usuario',
    'type'  => '3d',
);

if($estados)
{
    foreach ($estados as $estado)
    {
        $array_estados[$estado->estado] = 0; 
    }
}

if($usuarios)
{
    foreach ($usuarios as $usuario)
    {
        $array_usuarios[$usuario->usuario] = 0; 
    }
}

$array_fecha = datesBetween($inicio, $final, 'd/m');

if($array_fecha)
{
    foreach ($array_fecha as $fecha) 
    {
        $datos_barra['sumas'][$fecha] = 0;
    }    
}



if($registros)
{
    foreach ($registros as $row) 
    {
        $fecha = date('d/m', strtotime($row->date_add));
        
        if(isset($datos_barra['sumas'][$fecha]))
        {
            $datos_barra['sumas'][$fecha]   = $datos_barra['sumas'][$fecha] + $row->importe;
            $array_estados[$row->estado]    = $array_estados[$row->estado] + 1;
            $user = (int) $row->user_upd;
            
            if($user != '' && is_int($user))
            {
                $array_usuarios[$row->usuario] = $array_usuarios[$row->usuario] + 1;
            }
        }
    }   
}	

$scripts['tort']        = $graficos->torta($opcion_torta, $array_estados);
$scripts['usuarios']    = $graficos->torta($opcion_usuarios, $array_usuarios);
$scripts['bar']         = $graficos->barra($opcion_barra, $datos_barra);

foreach ($scripts as $script) 
{
	$html .= $script;
}

echo $html;
?>	