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
 
$_option_inicio = '';
$_option_final = '';
$_option_compuertas = '';

if($caminos)
{
    foreach ($caminos as $camino) 
    {
        $_camino = $camino->camino;    
		$_inicio = $camino->inicio;    
		$_final = $camino->final;
    }
}else
{
    $_camino = '';
}


foreach ($sectores as $sector) 
{
	if($sector->id_sector == $_inicio)
	{
		$_option_inicio .= '<option value="'.$sector->id_sector.'" selected>'.$sector->sector.'</option>';	
	}else
	{
		$_option_inicio .= '<option value="'.$sector->id_sector.'">'.$sector->sector.'</option>';
	}
	
	
	if($sector->id_sector == $_final)
	{
		$_option_final .= '<option value="'.$sector->id_sector.'" selected>'.$sector->sector.'</option>';	
	}else
	{
		$_option_final .= '<option value="'.$sector->id_sector.'">'.$sector->sector.'</option>';
	}
    
}


foreach ($compuertas as $compuerta) 
{
	$_option_compuertas .= '<option value="'.$compuerta->id_compuerta.'">'.$compuerta->compuerta.'</option>';
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
$html .= $_option_inicio;
$html .= '</select>';
$html .= '</div>';
$html .= '</div>';


$html .= '<div class="form-group">';
$html .= setLabel(lang('final'), 2);
$html .= '<div class="col-sm-8">';
$html .= '<select name="final" id="final" class="select2 form-control">';
$html .= $_option_final;
$html .= '</select>';
$html .= '</div>';
$html .= '</div>';

$html .= '<div class="form-group">';
$html .= '<div class="col-md-12 text-center">';

if($id_registro)
{
    $html .= '<input type="hidden" name="id_camino" value="'.$id_registro.'">';
    $html .= btnUpd();
		
	$html .= '<button type="button" class="btn btn-app" data-toggle="modal" data-target="#exampleModal">
    		<i class="fa fa-table"></i>
  			Detalle
			</button>';    
}else
{
    $html .= '<input type="hidden" name="id_camino" value="-1">';
    $html .= btnAdd();    
}




if($detalles)
{
	foreach ($detalles as $row_detalle) 
	{
		
	}
}



$html .= '</div>';
$html .= '</div>';

$html .= '</form>';


$cabeceras = array(
	lang('compuerta'),
    lang('valor'),
    lang('orden'),
    lang('opciones'),
);

$html .= startTable($cabeceras);

if($detalles)
{
	foreach ($detalles as $row_detalle) 
	{
		$registro = array(
			$row_detalle->compuerta,
            $row_detalle->valor,
            $row_detalle->orden,
            tableUpd($subjet, $row_detalle->id_detalle),
        );
        
        $html .= setTableContent($registro); 	
	}
}

$html .= endTable($cabeceras);         
$html .= setDatatables(); 


/*--------------------------------------------------------------------------------  
            Fin del contenido y js
 --------------------------------------------------------------------------------*/ 
 
$html .= endContent();

echo $html;
?>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="<?php echo base_url().'index.php/tambos_caminos/abm/'?>" method="post" class="form-horizontal">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
	        <?php
			$html = '';  
			$html .= '';
			                
			$html .= '<div class="form-group">';
			$html .= setLabel(lang('compuerta'), 2);
			$html .= '<div class="col-sm-10">';
			$html .= '<select name="compuerta" id="compuerta" class="select2 form-control">';
			$html .= $_option_compuertas;
			$html .= '</select>';
			$html .= '</div>';
			$html .= '</div>';
			
			
			$html .= '<div class="form-group">';
			$html .= setLabel(lang('valor'), 2);
			$html .= '<div class="col-sm-10">';
			$html .= '<input name="valor" id="valor" class="form-control">';
			$html .= '</div>';
			$html .= '</div>';
			
			$html .= '<div class="form-group">';
			$html .= setLabel(lang('orden'), 2);
			$html .= '<div class="col-sm-10">';
			$html .= '<input name="orden" id="orden" class="form-control">';
			$html .= '</div>';
			$html .= '</div>';
			
			$html .= '<input type="hidden" name="id_camino" value="'.$id_registro.'">';
			echo $html;
			?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary" value="detalle" name="detalle">Agregar</button>
			</div>
			</form>
		</div>
	</div>
</div>

<script>
$("[data-inputmask]").inputmask();
$(".checkbox").bootstrapSwitch();
</script>
