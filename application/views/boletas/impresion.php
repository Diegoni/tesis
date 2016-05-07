<?php
if(isset($impresiones)){
	foreach ($impresiones as $row) {
		$impresion = (array ) $row;
	}
}

if(!isset($lote_select)){
	$lote_select = 0;
}

/*--------------------------------------------------------------------------------	
 			Carga del select con los lotes
 --------------------------------------------------------------------------------*/	

$option = '<option></option>';
if($lotes_ant){
	foreach ($lotes_ant as $row) {
		$option  .= '<option value="'.$row->id_lote.'" ';
		if($lote_select == $row->id_lote){
			$option .= ' selected ';
		}
		$option .= ' >';
		$option .= $row->nombre;
		$option .= ': 1 : ';
		$option .= formatDate($row->fecha_venc_1).' $ '.$row->importe_venc_1;
		$option .= ' - ';
		$option .= ' 2 : ';
		$option .= formatDate($row->fecha_venc_2).' $ '.$row->importe_venc_2;
								
		$option .= '</option>';
	}
}
$select_lote = '<select name="id_lote" id="id_lote" class="form-control" onchange="this.form.submit()">'.$option.'</select>';

/*--------------------------------------------------------------------------------	
 			Contenido
 --------------------------------------------------------------------------------*/	

$html = start_content();
$html .= '<form method="post" class="form-horizontal" action="'.base_url().'index.php/'.$subjet.'/generar_impresion/">';
$html .= '<div class="row divider">';
$html .= setLabel($this->lang->line('lote'));
$html .= setLabel($select_lote, 9);
$html .= '<div class="col-md-2">';

/*--------------------------------------------------------------------------------	
 			Button de imprimir
 --------------------------------------------------------------------------------*/	

if(isset($impresiones)){
	$html .= '<button type="button" class="printer btn btn-app hide" value="Imprimir" id="imprimir">';
	$html .= '<i class="fa fa-print"></i> '.$this->lang->line('imprimir');
	$html .= '</button>';
	$html .= '<img src="'.base_url().'uploads/img/sitio/loading_small.gif" class="image divider" id="loading" height= "45px;" style="margin-bottom: 15px;">';		
}

$html .= '</div>';
$html .= '</div>';
$html .= '</form>';

/*--------------------------------------------------------------------------------	
 			Impresion de boletas
 --------------------------------------------------------------------------------*/	
 
if(isset($impresiones)){
	$html .= '<div class="print">';
	if($boletas){
		$total = 0;
		foreach ($boletas as $row) {
			$boleta			= $impresion['impresion'];
			$boleta_array = (array) $row;
								
			foreach ($impresiones_campos as $campos) {
				if($campos->formato == 'date'){
					$valor = formatDate($boleta_array[$campos->campo]);
				} else if($campos->formato == 'importe'){
					$valor = formatImporte($boleta_array[$campos->campo]);
				} else {
					$valor = $boleta_array[$campos->campo];
				}					
					
				$boleta		= str_replace ($campos->cadena , $valor , $boleta );
			}

			if($total != 0 && $total%$impresion['x_hoja'] == 0	){
				$html .= '<div class="saltopagina"></div><hr>';
			}
			$total = $total + 1;
								
			$html .= '<center>'.$boleta.'</center>';
			if(substr(phpversion(), 0, 1) < 5 || substr(phpversion(), 2, 1) < 3){
				$html .= setMensaje('Se necesita la versión 5.3 en adelante de PHP para generar las imágenes de los códigos de barra', 'error');
			} else {
				$html .= '<center><img width="400" src="'.base_url().'index.php/boletas/generacion_codigo/'.$row->codigo_barra.'"></center>';	
			}
			$html .= '<center>'.$row->codigo_barra.'</center>';
			
			$html .= '<br><hr>';
		}
	}
	$html .= '</div>';					
}
					
$html .= end_content();

echo $html;
?>

<script>
var beforeload = (new Date()).getTime();

function getPageLoadTime(){
	var afterload = (new Date()).getTime();
	seconds = (afterload-beforeload) / 1000;
	$(".printer" ).click(function() {
		$("#imprimir" ).slideUp('disabled').delay( seconds * 1000 + 300 ).fadeIn(400);
		$("#loading").fadeIn(400).delay( seconds * 1000 + 300 ).slideUp( 400 );

		$(".print").printThis({
			importStyle: true,
			printDelay: seconds * 1000 + 300
		});
	});
	
	$("#imprimir" ).removeClass('hide').fadeIn(400);
	$("#loading" ).slideUp(400);
}
window.onload = getPageLoadTime;

$(function() {
	$('#id_lote').chosen();
});
</script>

<style>
@media all {
   div.saltopagina{
      display: none;
   }
}
   
@media print{
   div.saltopagina{ 
      display:block; 
      page-break-before:always;
   }
}
</style>