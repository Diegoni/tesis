<?php
if($impresiones){
	foreach ($impresiones as $row) {
		$impresion = (array) $row;
	}
}

if($barcore){
	foreach ($barcore as $row) {
		$config = (array) $row;
	}
}

/*--------------------------------------------------------------------------------	
 			Carga de select
 --------------------------------------------------------------------------------*/	
 
if($barcore_formatos){
	$opciones_formato = setOption($barcore_formatos, 'id_formato', 'formato', $config['id_formato']);
}else{
	$opciones_formato = '<option></option>';
}
$select_formato = '<select name="id_formato" class="form-control">'.$opciones_formato.'</select>';


if($barcore_tipos){
	$opciones_tipos = setOption($barcore_tipos, 'id_tipo', 'tipo', $config['id_tipo']);
}else{
	$opciones_tipos = '<option></option>';
}
$select_tipos = '<select name="id_tipo" class="form-control">'.$opciones_tipos.'</select>';

/*--------------------------------------------------------------------------------	
 			Cabeceras del nav
 --------------------------------------------------------------------------------*/	

$html = start_content();

$html .= '<div class="tabbable">';
$html .= '<ul class="nav nav-tabs">';

foreach ($secciones as $row) {
	if($row == $seccion){
		$html .= '<li class="active"><a href="#tab_'.$row.'" data-toggle="tab">'.$this->lang->line($row).'</a></li>';
		$class_pane[$row] = 'tab-pane active divider';
	}else{
		$html .= '<li><a href="#tab_'.$row.'" data-toggle="tab">'.$this->lang->line($row).'</a></li>';
		$class_pane[$row] = 'tab-pane divider';
	}
}

$html .= '</ul>';

/*--------------------------------------------------------------------------------	
 			Impresiones
 --------------------------------------------------------------------------------*/	

$html .= '<div class="tab-content">';

if(isset($mensajes)){
	$html .= setMensaje('update_ok');
}

$textarea = '<textarea class="form-control" id="txt"  name="impresion">'.$impresion['impresion'].'</textarea>';
	
$html .= '<div class="'.$class_pane['impresion'].'" id="tab_impresion">';
$html .= '<form class="form-horizontal" method="post">';
$html .= '<div class="form-group">';
$html .= setLabel($this->lang->line('impresion'));
$html .= setLabel($textarea, 11);					
$html .= '</div>';									

$html .= '<div class="form-group">';					
$html .= setLabel($this->lang->line('x_hoja'));
$html .= setLabel('<input '.completar_tag('x_hoja', $impresion, 'onlyInt').' />', 2, 'input');
$html .= '</div>';			

$html .= button_upd(NULL, 12);	
$html .= '</form>';
$html .= '</div>';
	
/*--------------------------------------------------------------------------------	
 			Codigo de barra
 --------------------------------------------------------------------------------*/						
			
$html .= '<div class="'.$class_pane['codigo_barra'].'" id="tab_codigo_barra">';	
$html .= '<form class="form-horizontal" method="post" action="'.base_url().'index.php/config/impresion">';			

$html .= '<div class="form-group divider">';				
$html .= setLabel('X');
$html .= setLabel('<input '.completar_tag('canvas_x', $config, 'onlyInt').' />', 5, 'input');					
$html .= setLabel('Y');
$html .= setLabel('<input '.completar_tag('canvas_y', $config, 'onlyInt').' />', 5, 'input');
$html .= '</div>';
							
$html .= '<div class="form-group divider">';
$html .= setLabel($this->lang->line('width').' '.$this->lang->line('codigo'));
$html .= setLabel('<input '.completar_tag('width', $config, 'onlyInt').' />', 5, 'input');
$html .= setLabel($this->lang->line('height').' '.$this->lang->line('codigo'));
$html .= setLabel('<input '.completar_tag('height', $config, 'onlyInt').' />', 5, 'input');
$html .= '</div>';
				
$html .= '<div class="form-group divider">';
$html .= setLabel($this->lang->line('width').' '.$this->lang->line('cuadro').' '.$this->lang->line('codigo'));
$html .= setLabel('<input '.completar_tag('size_x', $config, 'onlyInt').' />', 5, 'input');
$html .= setLabel($this->lang->line('height').' '.$this->lang->line('cuadro').' '.$this->lang->line('codigo'));
$html .= setLabel('<input '.completar_tag('size_y', $config, 'onlyInt').' />', 5, 'input');
$html .= '</div>';

$html .= '<div class="form-group divider">';
$html .= setLabel($this->lang->line('formato'));
$html .= setLabel($select_formato, 5, 'select');
$html .= setLabel($this->lang->line('tipo'));
$html .= setLabel($select_tipos, 5, 'select');
$html .= '</div>';

$html .= button_upd('barcore', 12);
				
$html .= '</form>';		

$html .= '</div>';
$html .= '</div>';
$html .= '</div>';		
		
$html .= end_content();

echo $html;

/*--------------------------------------------------------------------------------	
 			Configuración del textEditor
 --------------------------------------------------------------------------------*/
 		
?>
<script>
var config = { extraPlugins: 'htmlbuttons'};
config.toolbar = [
 [<?php echo buttonTextEditor();?>], 
 
 <?php
	if(isset($campos)){
		$buttons = '';
		
		foreach ($campos as $row) {
			$buttons .= "'".$row->opcion."',";
		}
		
		$buttons = substr($buttons, 0, -1);
		
		echo "[".$buttons."]";
	}
 ?>

]

config.htmlbuttons = [
	<?php
	if(isset($campos)){
		$buttons = '';
		
		foreach ($campos as $row) {
			$icono = str_replace('#', '', $row->cadena).'.png';
			
			$buttons .= 
			"{
				name: '".$row->opcion."',
				icon: '".$icono."',
				html: '".$row->cadena."',
				title:'".$row->opcion."'
			},";
		}	
		
		$buttons = substr($buttons, 0, -1);
		
		echo $buttons ;
	}
	?>
];

CKEDITOR.replace('txt', config);
</script>