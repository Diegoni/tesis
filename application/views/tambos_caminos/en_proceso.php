<?php
/*--------------------------------------------------------------------------------  
            Comienzo del contenido
 --------------------------------------------------------------------------------*/
if($caminos)
{
    foreach ($caminos as $camino) 
    {
        $_camino = $camino->camino;    
		$_inicio = $camino->inicio;    
		$_final = $camino->final;
		$_img = $camino->img;
		$_date_upd = $camino->date_upd;
		$_date_now = date('Y-m-d H:i:s');
		
		$minutos = ceil((strtotime($_date_now) - strtotime($_date_upd)) / 60);

    }
}else
{
    $_camino = '';
	$minutos = 0;
}
 
  
$cabeceras = array(
    lang('animal'),
    lang('marcacion'),
);

$html = startContent();



 
if ($minutos > 5) {
     $error_minutos = 'Animales fuera del rango de tiempo permitido, '.$minutos.' minutos de retraso';
	
	$html .= setMensaje($error_minutos);
}


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

$button = '<center>';
$button .= '<form method="post" action="'.base_url().'index.php/tambos_caminos/cierre/">';		 

$button .= '<a class="btn btn-app" href="'.base_url().'/index.php/tambos_caminos/table/">';
$button	.= '<i class="fa fa-arrow-left"></i>';
$button	.= 'Volver';
$button	.= '</a>';

$button .= '<button class="btn btn-app" data-loading-text="'.$loading['loading'].'" name="cierre" id="cierre"  onclick="return confimaCierre()" type="submit" value="1">';
$button	.= '<i class="fa fa-close"></i>';
$button	.= lang('cierre');
$button	.= '</button>';
	
$button	.= $loading['script'];

$html .= $button;

$html .= '<button type="button" class="btn btn-app" data-toggle="modal" data-target="#imgModal">
    		<i class="fa fa-eye"></i>
  			Ver Camino
			</button></form></center>';
    
$html .= setDatatables(NULL, array(1, "desc"));           

/*--------------------------------------------------------------------------------  
            Fin del contenido
 --------------------------------------------------------------------------------*/
 
$html .= endContent();

echo $html;
?>

<div class="modal fade" id="imgModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Detalle camino</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
	        	<img src="<?php echo base_url().'assets/uploads/img/'.$_img.'.png'?>" />
	        	
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<script>

function confimaCierre(){
   confirm("Esta seguro de querer cerrar!");
}
</script>