<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* -------------------------------------------------------------------------------
INDICE

- setCss	       		Para cargar las librerias de CSS 
- setJs     			Para cargar las librerias de JS 
- armarMenu 			Arma el los items del menu de la izquierda
- permisosMenu			Arma el menu dependiendo de los permisos que tiene el usuario
- setDatatables			Carga las opciones del datatables, traduccion.
- estadoPago			Carga el label con el estado del pago
- setMensaje			Devuelve el html del mensaje cuando se realiza una accion
- btnAdd    	        Button para agregar registros en abm
- btnUpd			    Button para modificar registros en abm
- btnDlt			    Button para eliminar registros en abm
- btnRes			    Button para restaurar registros en abm
- btnUpl			    Button para subir archivos
- loadingButton			Efecto de carga cuando en los buttons
- tableButton           Para agregar link en la tabla
- tableAdd				Link para agregar registros
- tableUpd				Link para agregar modificar
- tableDlt				Button para eliminar varios registros
- setLabel				Arma los label de los formularios
- startContent			Comienza el contenido de una pagina con una sola columna 
- endContent			Finaliza el contenido de una pagina con una sola columna
- btnModal				Button que activa el modal
- getModal				Arma el mensaje modal
- getExportsButtons		Crea los buttons para la exportacion de las tablas
- startTable			Comienza las tablas
- endTable				Finaliza las tablas
- setTableContent		Para agregar lineas en la tabla 
- setBoxHome			Arma el box del home para bancos
- setGraficoDiv			Arma el div para insertar el grafico
- getColorAction		Arma los label para las distintas acciones de los logs
- getIcon				Trae el icono del sistema correspondiente
- setProfile			Arma el profile con los datos del afiliado.
- setJsonContent		Para agregar elementos en json
- setSpan				Para armar el span label 
- setBoxSolid			Arma un panel con titulo y contenido 
- completarTag			Carga los valores basicos en los input, nombre, id, value, placeholder, type y limita el onkeypress
- setConfigInput		Carga de los input en el modulo config
- buttonTextEditor		Buttons para el text editor 
- setOption				Carga los options en los select
- getCheck				Para estado, check o no 1 o 0
- setRequired           Devuelve array con tabs
- setForm               Crea el formulario para el abm
- getEffects            Devuelve los efectos para las librerias wow
- getBootstrapSwitch    Devuelve el checkbox con bootstrap switch
  -------------------------------------------------------------------------------*/


function setCss($css)
{
	$directorio = base_url().'librerias/plantilla/'.$css;
	return '<link rel="stylesheet" href="'.$directorio.'">';
}



function setJs($js)
{
	$directorio = base_url().'librerias/plantilla/'.$js;
	return '<script src="'.$directorio.'"></script>';
}



function armarMenu($titulo, $icono, $submenu)
{
	$menu  = '<li class="treeview">';
	$menu .= '<a href="#">';
	$menu .= '<i class="fa '.$icono.'"></i>';
	$menu .= '<span>'.$titulo.'</span>';
    $menu .= '<i class="fa fa-angle-left pull-right"></i>';
    $menu .= '</a>';
    $menu .= '<ul class="treeview-menu">';
    
	foreach ($submenu as $key => $value) {
		if($value['icono'] == ''){
			$value['icono'] = '<i class="fa fa-circle-o"></i>';
		}
		
		$menu .= '<li><a href="'.base_url().'index.php/'.$value['vista'].'">'.$value['icono'].' '.$key.'</a></li>';
	}
	$menu .= '</ul>';
    $menu .= '</li>';
	
	return $menu;
}



function permisosMenu($array_send, $permisos_menu_array, $id_perfil)
{	
	foreach ($array_send as $menu => $valores) {
		if($permisos_menu_array[$valores['permiso']] == 1){
			if(!isset($valores['icono'])){
				$valores['icono'] = '';
			}
			
			if(($id_perfil == 2 && $valores['vista'] == 'table' && $valores['permiso'] == 'entes')){ /// excepciones
					
			}else{
				$array_return[$menu] = array(
					'vista'		=> $valores['permiso'].'/'.$valores['vista'],
					'icono'		=> $valores['icono'],
				);
			}
		}
	}
	
	if(isset($array_return)){
		return $array_return;
	}else{
		return FALSE;
	}
}



function setDatatables($id_table = NULL, $order = NULL, $url = NULL)
{
	if($id_table == NULL){
		$id_table = 'table_registros';
	}
	
	$cor = '"';
	
	$filtro = " $('#".$id_table." tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input class=".$cor."form-control input-sm".$cor." type=".$cor."text".$cor." placeholder=".$cor."'+title+'".$cor." style=".$cor."width: 75%".$cor.";/>' );
    } );; ";
    
    $data = setCss('plugins/datatables/dataTables.bootstrap.css'); 
	$data .= setJs('plugins/datatables/jquery.dataTables.min.js');
	$data .= setJs('plugins/datatables/dataTables.bootstrap.min.js');

	$data .=
	'<script>
		$(function () {
			'.$filtro.'
			 
        	var table = $("#'.$id_table.'").DataTable({';
	
	if($url != NULL){ // Carga de datos en ajax
		$data .= 
			'ajax: {
	            url: "'.$url.'",
	            type: "POST"
	        }, ';
	}
		
	$data .= '	
		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        	"language": {
		        "sProcessing":    "Procesando...",
		        "sLengthMenu":    "Mostrar _MENU_ registros",
		        "sZeroRecords":   "No se encontraron resultados",
		        "sEmptyTable":    "Ningún dato disponible en esta tabla",
		        "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
		        "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
		        "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
		        "sInfoPostFix":   "",
		        "sSearch":        "Buscar:",
		        "sUrl":           "",
		        "sInfoThousands":  ",",
		        "sLoadingRecords": "Cargando...",
		        "oPaginate": {
		            "sFirst":   "Primero",
		            "sLast":    "Último",
		            "sNext":    "Siguiente",
		            "sPrevious":"Anterior"
		        },
		        "oAria": {
		            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
		            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
		        }
   	 		}'; // Opciones de la libreria, contenido en español
				
	if($order != NULL){ // Orden inicial de la tabla
		if(is_array($order)){
			if(isset($order[1]) && $order[1] != 'asc'){				
				$data .= ', "order": [[ '.$order[0].', "desc" ]]';
			}else{
				$data .= ', "order": [[ '.$order[0].', "asc"  ]]';
			}
		}else{
			$data .= ', "order": [[ '.$order.' , "asc" ]]';
		}
		
	}

	$data .= '});';
	
	$data .=  "table.columns().every( function () {
	        var that = this;
	 
	        $( 'input', this.footer() ).on( 'keyup change', function () {
	            if ( that.search() !== this.value ) {
	                that
	                    .search( this.value )
	                    .draw();
	            }
	        } );
	    } );
	} );"; // filtros en footer de la tabla
	  
	  
	$data .= 
	'</script>';
    return $data;
}



function estadoPago($pago)
{
	if($pago == -1){
		$mensaje = setSpan(lang('eliminado'), 'danger');
	}else if($pago == 0){
		$mensaje = setSpan(lang('falta_pago'), 'warning');
	}else{
		$mensaje = setSpan(lang('pagada'), 'success');
	}
	
	return $mensaje;
}



function setMensaje($alert, $tipo = NULL)
{
	$mensaje = '';	
    $set_efectos = 0;
		
	if($alert == 'update_ok'){
		$class = 'success';
		$title = '<i class="fa fa-check"></i> '.lang('ok');
		$alert = lang('update_ok');
        $efect = getEffects();
	}else if($alert == 'insert_ok'){
		$class = 'success';
		$title = '<i class="fa fa-check"></i> '.lang('ok');
		$alert = lang('insert_ok');
		$efect = getEffects();
	}else if($tipo == 'error'){
		$class = 'danger';
		$title = '<i class="fa fa-ban"></i> '.lang('error');
		$alert = $alert;
		$efect = 'shake';
	}else if($tipo == 'danger'){
		$class = 'danger';
		$title = '<i class="fa fa-exclamation-triangle"></i> '.lang('error');
		$alert = $alert;	
        $efect = 'shake';
	}else if($tipo == 'warning'){
		$class = 'warning';
		$title = '<i class="fa fa-exclamation-triangle"></i> '.lang('advertencia');
		$alert = $alert;
        $efect = getEffects();
	}else if($tipo == 'ok' || $tipo == 'info'){
		$class = 'info';
		$title = '<i class="fa fa-info-circle"></i> '.lang('informacion');
		$alert = $alert;
        $efect = getEffects();
	}else{
		$class = 'danger';
		$title = '<i class="fa fa-exclamation-triangle"></i> '.lang('error');
		$alert = $alert;	
        $efect = 'shake';
	}
    	
    $mensaje .= '<div class="row">';
    $mensaje .= '<div class="col-md-6 col-md-offset-3">';
    if($set_efectos == 1){
        $mensaje .= '<div class="alert alert-'.$class.' alert-dismissable divider '.$efect.' wow" id="alert" data-wow-duration="2s">';    
    }else{
        $mensaje .= '<div class="alert alert-'.$class.' alert-dismissable divider" id="alert">';
    }
    
	$mensaje .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
	$mensaje .= $title;
	$mensaje .= '<p>'.$alert.'</p>';
	$mensaje .= '</div>';
	$mensaje .= '</div>';
    $mensaje .= '</div>';
	
	return $mensaje;
}



function btnAdd($agregar_per = NULL)
{
	if($agregar_per == NULL){
		$name = 'agregar';
		$text = lang('agregar');
	}else{
		$name = 'agregar_per';
		$text = lang('agregar_per');
	}
	$loading = loadingButton();	

	$button = '<button class="btn btn-app" data-loading-text="'.$loading['loading'].'" name="'.$name.'" id="'.$name.'" type="submit" value="1">';
	$button	.= '<i class="fa fa-plus-square-o"></i>';
	$button	.= $text;
	$button	.= '</button>';
	
	$button	.= $loading['script'];
	
	return $button;
}



function btnUpd($name = NULL, $col = NULL)
{
	if($name == NULL){
		$name = 'modificar';
	}	
	$loading = loadingButton();	
	
	if($col == NULL){
		$button = '';
	}else{
		$button = '<div class="form-group">';
		$button .= '<div class="col-sm-12 text-center">';
	}
	
	$button .= '<button class="btn btn-app" data-loading-text="'.$loading['loading'].'" name="'.$name.'" id="'.$name.'" type="submit" value="1">';
	$button	.= '<i class="fa fa-pencil-square-o"></i>';
	$button	.= lang('actualizar');
	$button	.= '</button>';
	
	if($col != NULL){
		$button .= '</div>';
		$button .= '</div>';
	}
	
	$button	.= $loading['script'];
	
	return $button;
}



function btnDlt()
{
	$loading = loadingButton();			
	
	$mensaje= "'".lang('confirma_accion')."'";
	$button = '<button class="btn btn-app" data-loading-text="'.$loading['loading'].'" name="eliminar" type="submit" value="1" onclick="return confirm('.$mensaje.')">';
	$button	.= '<i class="fa fa-trash"></i>';
	$button	.= lang('eliminar');
	$button	.= '</button>';
	
	$button	.= $loading['script'];
	
	return $button;
}



function btnRes()
{
	$loading = loadingButton();	
	
	$mensaje= "'".lang('confirma_accion')."'";
	$button = '<button class="btn btn-app" data-loading-text="'.$loading['loading'].'" name="restaurar" type="submit" value="1" onclick="return confirm('.$mensaje.')">';
	$button	.= '<i class="fa fa-level-up"></i>';
	$button	.= lang('restaurar');
	$button	.= '</button>';
	
	$button	.= $loading['script'];
	
	return $button;
}



function btnUpl()
{
	$loading = loadingButton();	
	
	$button = '<hr>';
	$button .= '<button type="submit"  data-loading-text="'.$loading['loading'].'" id="btnUpl" value="upload" class="btn btn-app" />';
	$button .= '<i class="fa fa-upload"></i>';
	$button	.= lang('upload');		
	$button	.= '</button>';
	
	$button	.= $loading['script'];
	
	return $button;
}



function loadingButton()
{
	$button['loading']	= "<i class='fa fa-circle-o-notch fa-spin'></i> ".lang('cargando'); // Icono girando 
	$button['script']	= 
	"<script>
		$('.btn-app').on('click', function() {
			var variable = $(this);
				variable.button('loading');
		});
	</script>"; // Onclick carga del loading
	
	return $button;
}



function tableButton($link, $id, $icon = NULL, $title = NULL)
{
    if($icon == NULL){
        $icon = 'fa fa-square-o';
    }    
    
    if($title != NULL){
        $title = 'title="'.$title.'"';
    }
    
    $button = '<a href="'.base_url().'index.php/'.$link.'/'.$id.'" class="btn btn-default" '.$title.'>';
    $button .= '<i class="'.$icon.'"></i>';
    $button .= '</a>';
    
    return $button;
}



function tableAdd($subjet)
{
	$button = '<a href="'.base_url().'index.php/'.$subjet.'/abm" class="pull-right btn btn-default btn-table">';
	$button .= '<i class="fa fa-plus-square-o"></i> '.lang('nuevo');
	$button .= '</a>';
	
	return $button;
}



function tableUpd($subjet, $id)
{
	$button = '<a href="'.base_url().'index.php/'.$subjet.'/abm/'.$id.'" class="btn btn-default" title="Modificar">';
	$button .= '<i class="fa fa-pencil-square-o"></i>';
	$button .= '</a>';
	
	return $button;
}



function tableDlt()
{
	$mensaje= "'".lang('confirma_accion')."'";
	$button = '<button class="btn btn-default pull-right btn-table" name="delete" value="delete" id="delete" onclick="return confirm('.$mensaje.')">	';
	$button .= '<i class="fa fa-trash"></i> '.lang('eliminar');
	$button .= '</button>';
	
	return $button;
}



function setLabel($text, $size = NULL, $type = NULL, $id = NULL)
{
	if($size == NULL){
		$size = 1;
	}
    
    if($id != NULL){
        $id = 'id="label_'.$id.'"';  
    }else {
        $id = '';
    }
	
	if($type == NULL){
		$label = '<label class="col-sm-'.$size.' control-label" '.$id.' >';
		$label .= $text;
		$label .= '</label>';	
	} else{
		$label = '<div class="col-sm-'.$size.'">';
		$label .= $text;
		$label .= '</div>';	
	}
	
	return $label;
}



function startContent($size = NULL)
{
	if($size == NULL){
		$size = 12;
	}	
	
	$content = '<section class="content">';
	$content .= '<div class="row">';
	$content .= '<section class="col-lg-'.$size.'">';
	$content .= '<div class="box box-info">';
	$content .= '<div class="box-body">';
	
	return $content;
}



function endContent()
{
	$content = '</div>';
	$content .=	'</div>';
	$content .=	'</section>';
	$content .= '</div>';
	$content .= '</section>';
	
	return $content;
}



function btnModal($id)
{
	$button = '<button type="button" class="btn btn-default" data-toggle="modal" data-target="#'.$id.'">';
	$button .= '<i class="fa fa-question-circle"></i>';
	$button .= '</button>';
	
	return $button;
}



function getModal($id, $mensaje)
{
	
	$modal = '<div class="modal fade" id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">';
	$modal .= '<div class="modal-dialog" role="document">';
	$modal .= '<div class="modal-content">';
	$modal .= '<div class="modal-header">';
	$modal .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
	$modal .= '<h4 class="modal-title" id="myModalLabel">';
	$modal .= '<i class="fa fa-question-circle"></i> Ayuda';
	$modal .= '</h4>';
	$modal .= '</div>';
	$modal .=' <div class="modal-body">';
    $modal .= $mensaje; 			
    $modal .= '</div>';
    $modal .= '<div class="modal-footer">';
    $modal .= '<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>';
    $modal .= '</div>';
    $modal .= '</div>';
  	$modal .= '</div>';
	$modal .= '</div>';
	
	return $modal;
}



function getExportsButtons($cabeceras, $button = NULL, $id_table = NULL)
{
	if($id_table == NULL){
		$id_table = 'table_registros';
	}
	
	$return =
	'<script language="javascript">
	$(document).ready(function() {
		$(".botonExcel").click(function(event) {
			$("#datos_a_enviar").val( $("<div>").append( $("#'.$id_table.'").eq(0).clone()).html());
			$("#export").val($(this).attr("value"));
			$("#FormularioExportacion").submit();
		});
	});
	</script>';	
	
	$ci		=& get_instance();
	$url	=  base_url().'index.php/'.$ci->uri->segment(1).'/'.'armarExport';
	
	$return .= 	
	'<div class="col-md-6"></div>
	<div class="col-md-6" style=" padding-bottom: 5px;">
		<form action="'.$url.'" method="post" target="_blank" id="FormularioExportacion" class="pull-right">
			<input id="export" name="export" type="hidden">
			<button class="btn btn-default botonExcel" name="pdf" 	value="pdf"><i class="fa fa-file-pdf-o"></i> PDF</button>
			<button class="btn btn-default botonExcel" name="excel" value="excel"><i class="fa fa-file-excel-o"></i> Excel</button>
			<button class="btn btn-default botonExcel" name="print" value="print"><i class="fa fa-print"></i> Imprimir</button> 	
			 ';
	
	
	foreach ($cabeceras as $cabecera) {
		if(is_array($cabecera)){
			foreach ($cabecera as $key => $value) {
				$return .= '<input type="hidden" name="cabeceras[]" value="'.$key.'"/>';	
			}
		}else{
			$return .= '<input type="hidden" name="cabeceras[]" value="'.$cabecera.'"/>';	
		}
	}
	
	$return .= 	
		'	<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
		</form>';
	
	if($button != NULL){
		$return .= $button.'  ';
	}	
	
	$return .= '</div>';
	
	return $return;
}



function startTable($cabeceras = NULL, $id_table = NULL, $class = NULL)
{
	if($id_table == NULL){
		$id_table = 'table_registros';
	}
	
	$table = 
	'<table class="table table-hover table-responsive dataTable '.$class.'" id="'.$id_table.'">';
	
    if($cabeceras !== NULL){
        $table .= 
        '<thead> <tr class="success">';
        foreach ($cabeceras as $cabecera) {
            if(is_array($cabecera)){
                foreach ($cabecera as $key => $value) {
                    $table .= '<th title="'.$key.'">'.$value.'</th>';
                }
            }else{
                $table .= '<th>'.$cabecera.'</th>'; 
            }
        }
        $table .= '</tr> </thead>';    
    }
    
    $table .= '<tbody>';
    
	return $table;
}



function endTable($cabeceras = NULL)
{
	$table = '';
		
	if($cabeceras != NULL){
		$table .= '<tfoot> <tr>';
		foreach ($cabeceras as $cabecera) {
			if(is_array($cabecera)){
				foreach ($cabecera as $key => $value) {
					$table .= '<th title="'.$key.'">'.$value.'</th>';	
				}
			}else{
				$table .= '<th>'.$cabecera.'</th>';
			}
		}
		$table .= '</tr> </tfoot>';
	}
	
	$table .= '</tbody> </table>';
	
	return $table;
}



function setTableContent($registros, $class = NULL)
{
    if($class != NULL){
        $content = '<tr class="'.$class.'">';    
    }else{
        $content = '<tr>';
    }
	foreach ($registros as $registro) {
		if(is_array($registro)){
			foreach ($registro as $key => $value) {
				$content .= '<td title="'.$key.'">'.$value.'</td>';	
			}
		}else{
			$content .= '<td>'.$registro.'</td>';
		}
	}
	$content .= '</tr>';
	
	return $content;
}



function setCheckbox($check, $registro, $checked = NULL)
{
	$return = setLabel(lang($check), 2);
	$return .= '<div class="col-sm-8 text-center">';
	$return .= '<input type="checkbox" name="'.$check.'" id="'.$check.'" class="checkbox" value="'.$registro[$check].'"';
	
	if($checked === NULL && $registro[$check] == 0){
		$return .= '>';	
	}else{
		$return .= ' checked>';
	}
	$return .= '</div>';		
				
	return $return;		
}



function setBoxHome($arreglo)
{
	$box  = '<div class="col-lg-3 col-xs-6">';
	$box .= '<div class="small-box '.$arreglo['color'].'">';
	$box .= '<div class="inner">';
	$box .= '<h3>'.$arreglo['title'].'</h3>';
	$box .= '<p>'.$arreglo['subtitle'].'</p>';
	$box .= '</div>';
	$box .= '<div class="icon">';
	$box .= '<i class="'.$arreglo['icon'].'"></i>';
	$box .= '</div>';
	$box .= '<a href="'.$arreglo['link'].'" class="small-box-footer">';
	$box .= 'Ver <i class="fa fa-arrow-circle-right"></i>';
	$box .= '</a>';
	$box .= '</div>';
	$box .= '</div>';
	
	return $box;
}



function setGraficoDiv($id, $size = NULL, $class = NULL)
{
    if($size == NULL){
        $size = 6;
    }
    
    if($class == NULL){
        $class = 'info';
    }  
    
    if($size == '0'){
        $div = '<div class="box box-info">';
        $div .= '<div id="'.$id.'"></div>';
        $div .= '</div>';
    }else{
        $efecto = getEffects();
         
        $div = '<section class="col-md-'.$size.'">';
        $div .= '<div class="box box-'.$class.' '.$efecto.' wow" data-wow-duration="2s">';
        $div .= '<div class="box-body" >';
        $div .= '<div id="'.$id.'"></div>';
        $div .= '</div>';
        $div .= '</div>';
        $div .= '</section>';
    }

    return $div;
}



function getColorAction($action)
{
	if($action == 'insert'){
		$return = setSpan('<i class="fa fa-plus-square-o"></i> '.$action, 'default');
	}else if($action == 'log out'){
		$return = setSpan('<i class="fa fa-sign-out"></i> '.$action, 'warning');
	}else if($action == 'log in'){
		$return = setSpan('<i class="fa fa-sign-in"></i> '.$action, 'success');
	}else if($action == 'delete'){
		$return = setSpan('<i class="fa fa-trash"></i> '.$action, 'danger');
	}else if($action == 'update'){
		$return = setSpan('<i class="fa fa-pencil-square-o"></i> '.$action, 'primary');
	}else if($action == 'restore'){
		$return = setSpan('<i class="fa fa-level-up"></i> '.$action, 'info');
	}else{
		$return = $action;
	}
	
	return $return;
}



function getIcon($cadena)
{	
	if($cadena == ''){
		$return = '';
	}else if(strstr($cadena, 'Chrome')){
		$return = '<i class="fa fa-chrome"></i> '.$cadena;
	}else if(strstr($cadena, 'Firefox')){
		$return = '<i class="fa fa-firefox"></i> '.$cadena;
	}else if(strstr($cadena, 'Edge')){
		$return = '<i class="fa fa-edge"></i> '.$cadena;
	}else if(strstr($cadena, 'explorer')){
		$return = '<i class="fa fa-internet-explorer"></i> '.$cadena;
	}else if(strstr($cadena, 'Opera')){
		$return = '<i class="fa fa-opera"></i> '.$cadena;
	}else if(strstr($cadena, 'Safari')){
		$return = '<i class="fa fa-safari"></i> '.$cadena;
	}else if(strstr($cadena, 'Windows')){
		$return = '<i class="fa fa-windows"></i> '.$cadena;
	}else if(strstr($cadena, 'Linux')){
		$return = '<i class="fa fa-linux"></i> '.$cadena;
	}else if(strstr($cadena, 'Android')){
		$return = '<i class="fa fa-android"></i> '.$cadena;	
	}else if(strstr($cadena, 'Mac')){
		$return = '<i class="fa fa-apple"></i> '.$cadena;	
	}else if(strstr($cadena, 'Spartan')){
		$return = '<i class="fa fa-edge"></i> '.$cadena;	
	}else{
		$return = $cadena;
	}

	return $return;
}



function setProfile($afiliado)
{
	$seccion = 
	'<div class="col-md-3">
		<div class="box box-primary">
			<div class="box-body box-profile">
				<img class="profile-user-img img-responsive img-circle" src="'.base_url().'uploads/img/sitio/user.png" alt="User profile picture">
				<h4 class="profile-username text-center">'.$afiliado['apellido'].'</h4>
				<p class="text-muted text-center">'.$afiliado['nombre'].'</p>
	
				<ul class="list-group list-group-unbordered">
					<li class="list-group-item">
						<b><i class="fa fa-map-marker margin-r-5"></i>  '.lang('direccion').'</b> 
						<p class="dato_afiliado">'.$afiliado['calle'].' '.$afiliado['numero'].'</p>
					</li>
					<li class="list-group-item">
						<b><i class="fa fa-phone margin-r-5"></i> '.lang('telefono').'</b> 
						<p class="dato_afiliado">'.$afiliado['telefono'].'</p>
					</li>
					<li class="list-group-item">
						<b><i class="fa fa-envelope-o margin-r-5"></i> '.lang('email').'</b> 
						<p class="dato_afiliado">'.$afiliado['email'].'</p>
					</li>
				</ul>
	
				<a href="'.base_url().'index.php/afiliados/abm/'.$afiliado['id_afiliado'].'" class="btn btn-default btn-block"><b>'.lang('ver').'</b></a>
			</div>
		</div>
	</div>';
	
	return $seccion;	
}



function setJsonContent($registros)
{
	$json = ' [ ';
	foreach ($registros as $registro) {
		$registro = str_replace('"', "'", $registro);
		$json .= '"'.$registro.'", ';
	}
	$json = substr($json, 0, -2);
	$json .= ' ], ';
	
	return $json;
}



function setSpan($mensaje, $class = NULL)
{
    if($mensaje == 1){
        $mensaje = '<i class="fa fa-check"></i>';
        $class = 'success';
    }else if($mensaje == '0'){
        $mensaje = '<i class="fa fa-ban"></i>';
        $class = 'danger';
    }    
    
	if(	$class == NULL		|| (
		$class != 'default' && 
		$class != 'primary' && 
		$class != 'success' && 
		$class != 'info' 	&& 
		$class != 'warning' &&
		$class != 'danger')){
			$class = 'default';
	}

	return '<span class="label label-'.$class.'">'.$mensaje.'</span>';
} 



function setBoxSolid($header, $body, $size = NULL)
{
	if($size == NULL){
		$size = 6;
	} 
	
	$box = '<div class="col-md-'.$size.'">';
	
	if(is_array($header)){
	    if(isset($header['tags'])){
	       $tags = $header['tags'];
	    }else{
	       $tags = ''; 
	    }

        $efecto = getEffects();
        
		$box .=
		'<div class="box '.$tags.' box-'.$header['class'].' '.$efecto.'  wow " data-wow-duration="2s">
		<div class="box-header">
			<h3 class="box-title">'.$header['title'].'</h3>
		</div>';
	}else{
		$box .=
		'<div class="box box-default">
		<div class="box-header">
			<h3 class="box-title">'.$header.'</h3>
		</div>';
	} 
	 
	$box .= '<div class="box-body">'.$body.'</div>';
	$box .= '</div></div>';
	
	return $box;
}



function getLimite($limit, $value){
    $input = ' ';
    
    if($limit == 'onlyChar' || $limit == 'Char'){
        $input .= 'onkeypress="return onlyChar(event)" ';   
    }else if($limit == 'onlyFloat' || $limit == 'Float'){
        $input .= 'onkeypress="return onlyFloat(event)" ';
    }else if($limit == 'onlyCharInt' || $limit == 'CharInt'){
        $input .= 'onkeypress="return onlyCharInt(event)" ';
    }else if($limit == 'onlyInt' || $limit == 'Int'){
        $input .= 'onkeypress="return onlyInt(event)" ';
    }else if($limit == 'false'){
        $input .= 'onkeypress="return false" ';
    }else if($limit == 'unique'){
        $value = "'$value'";
        $input .= 'onkeypress="getUnique(this.name, this.value+String.fromCharCode(event.keyCode), '.$value.')" unique ';
    }else{
        $input .= "data-inputmask='";
        $input .= '"mask": "';
        $input .= $limit;
        $input .= '"';
        $input .= "'";
    }

    return $input.' ';
}



function completarTag($campo, $value = NULL, $limit = NULL, $class = NULL)
{	
	$input = 'name="'.$campo.'" ';
	$input .= 'id="'.$campo.'" '; 
	//$input .= 'type="text" ';
	if($class == NULL)
	{
		$input .= 'class="form-control"  ';	
	}else{
		$input .= 'class="form-control '.$class.'"  ';
	}
	
	$input .= 'placeholder="'.lang($campo).'" '; 
	if(is_array($value)){
	    if(isset($value[$campo])){
	       $input .= 'value="'.$value[$campo].'" ';    
	    }
	}else if($value != NULL){
		$input .= 'value="'.$value.'" ';	
	}
    
    if($limit != NULL){
        if(is_array($limit)){
            foreach ($limit as $_limit) {
                $input .= getLimite($_limit, $value);
            }
            
        }else{
            $input .= getLimite($limit, $value);
        }
	}
	 
	return $input;	
}




function setConfigInput($campo, $value)
{
	$input = '<input '.completarTag($campo, $value, 'onlyInt').' />';
	$label = '<div class="form-group">';
	$label .= setLabel(lang($campo), 2);
	$label .= setLabel($input, 2, 'input');
	$label .= setLabel(lang('info_'.$campo), 8, 'text'); 
	$label .= '</div>';
	
	return $label;
}



function buttonTextEditor()
{
	$buttons = "	
'-',
	'Source',
	'Save',
	'NewPage',
	'DocProps',
	'Preview',
	'Print',
	'Templates',
	'document',
'-',
	'Cut',
	'Copy',
	'Paste',
	'PasteText',
	'Undo',
	'Redo',


'-',
	'Bold',
	'Italic',
	'Underline',
	'Strike',
	'Subscript',
	'Superscript',
	'RemoveFormat',
'-',
	'NumberedList',
	'BulletedList',
	'Outdent',
	'Indent',
	'Blockquote',
	'CreateDiv',
	'JustifyLeft',
	'JustifyCenter',
	'JustifyRight',
	'JustifyBlock',
	'BidiLtr',
	'BidiRtl',
'-',
	'CreatePlaceholder',
	'Image',
	'Flash',
	'Table',
	'HorizontalRule',
	'Smiley',
	'SpecialChar',
	'PageBreak',
	'Iframe',
	'InsertPre',
'-',
	'Styles',
	'Format',
	'Font',
	'FontSize',
'-',
	'TextColor',
	'BGColor',
'-',
	'UIColor',
	'Maximize',
	'ShowBlocks',";
	
	return $buttons;
}



function setOption($array, $id, $value, $selected = NULL)
{
	$opciones = '<option></option>';
	
	if($array){
    	foreach ($array as $row) {
    		if($selected == NULL){
    			$select = '';
    		}else if(is_array($selected) && in_array($row->{$id}, $selected)){
    			$select = 'selected';
    		}else if($row->{$id} == $selected){
    			$select = 'selected';
    		}else{
    			$select = '';
    		}
    
    		$opciones .= '<option value="'.$row->{$id}.'" '.$select.'>';
    		
    		if(is_array($value)){
    			foreach ($value as $valores) {
    				$opciones .= $row->{$valores}.' ';
    			}
    			$opciones .= '</option>';
    		}else{
    			$opciones .= $row->{$value}.'</option>';	
    		}
    	}
	
	   return $opciones;
	}
}



function getCheck($flag)
{
	if($flag == 1){
		return setSpan('<i class="fa fa-check"></i>', 'success');
	}else{
		return ' ';
	}
}



function setRequired($campo)
{
    if(isset($campo) && $campo != NULL)
    {
        if(is_array($campo))
        {
            foreach ($campo as $tag) 
            {
                if($tag == 'required')
                {
                    $return['required'] = 1;
                }
                 
                $return['tags'] = $tag.' ';     
            }
        } else 
        {
            if($campo == 'required')
            {
                $return['required'] = 1;
            } 
                    
            $return['tags'] = $campo;
        }        
    }  
    
    return $return; 
}



function setForm($campos, $registro_values, $registro, $id_table)
{
    $ci             =& get_instance();
    $fields_data    = $ci->db->field_data($ci->model->getTable());
    $session        = $ci->session->userdata('logged_in');
    
    $fields_s = array(
        'date',
        'datetime',
        'time',
        'text'
    );
    $return = '';
    
     //-- Carga de los select --
    foreach ($campos as $campo) 
    {
        if($campo[0] == 'select')
        {
            if($campo[3])
            {
                $$campo[1] = setOption($campo[3], $campo[1], $campo[2], $registro_values[$campo[1]]);
            }else 
            {
                $$campo[1] = '<option></option>';
            }
        }
    }
     //-- Carga del formulario --
    foreach ($campos as $campo) 
    {
        $return .= '<div class="form-group">'; 
        //-- div --
        if($campo[0] == 'div')
        {
            $return .= '<b><h4 class="box-title pull-right" style="margin-right: 15px;">'.lang($campo[1]).'</h4></b><hr>';
        //-- checkbox --
        }else if($campo[0] == 'checkbox')
        {
            $return .= setCheckbox($campo[1],      $registro_values);
        //-- select --       
        }else if($campo[0] == 'select')
        {
             $tags       = '';
             $required   = 0;
             
             if(isset($campo[4]) && $campo[4] != NULL)
             {
                if(is_array($campo[4]))
                {
                    foreach ($campo[4] as $tag) 
                    {
                        if($tag == 'required')
                        {
                            $required = 1;
                        } 
                        $tags = $tag.' ';     
                    }
                } else 
                {
                    if($campo[4] == 'required')
                    {
                        $required = 1;
                    } 
                    
                    $tags = $campo[4];
                }        
            }
   
            if(is_array($campo[2]))
            {
                $_nombre = '';
                foreach ($campo[2] as $_campo_nombre) 
                {
                    $_nombre .= lang($_campo_nombre).' ';
                }
            }else
            {
                $_nombre = lang($campo[2]);
            }           
            $return .= setLabel($_nombre, 2, NULL, $campo[1]);
            $return .= '<div class="col-sm-8">';
            
            if($required == 1){
                 $return .= '<div class="input-group">';                
            }
            
            $return .= '<select name="'.$campo[1].'" id="'.$campo[1].'" class="select2 form-control" '.$tags.'>';
            $return .= $$campo[1];
            $return .= '</select>';
            
            if($required == 1)
            {
                $return .= '<span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>';
                $return .= '</div>';
            }
            
            $return .= '</div>';
        //-- inputs --                    
        }else
        {
            $tags       = '';
            $required   = 0;
        
            if(isset($campo[2]) && $campo[2] != NULL)
            {
                if(is_array($campo[2]))
                {
                    foreach ($campo[2] as $tag) 
                    {
                        if($tag == 'required')
                        {
                            $required = 1;
                        } 
                        
                        $tags = $tag.' ';     
                    }
                } else 
                {
                    if($campo[2] == 'required')
                    {
                        $required = 1;
                    } 
                        
                    $tags = $campo[2]; 
                }        
            }   
            
            $return .= setLabel(lang($campo[0]), 2, NULL, $campo[0]);
            $return .= '<div class="col-sm-8">';
            
            if($required == 1)
            {
                $_validaciones = array(
                    'email',
                    'unique',
                    'phone',
                    'cuit',
                    'transaccion',
                    'length',
                    'number',
                );
                   
                $return .= '<div class="input-group" ';
                 
                if(is_array($campo[1])){
                    foreach ($campo[1] as $campo_1) {
                        if(in_array($campo_1, $_validaciones)){
                            $return .= 'data-validate="'.$campo_1.'"';
                        } 
                    } 
                }else{
                    if(in_array($campo[1], $_validaciones)){
                        $return .= 'data-validate="'.$campo[1].'"';
                    }
                }
                
                $return .= ' >';
                 
            }
            
            $class_input = NULL;
            
            foreach ($fields_data as $fdata) 
            {
                if($fdata->name == $campo[0])
                {
                    if(in_array($fdata->type, $fields_s))
                    {
                        $class_input = $fdata->type;   
                    }
                }
            }
            
            if(isset($campo[3]))
            {
                $valor_input =  $campo[3];    
            } else if($registro_values == '')
            {
                $valor_input =  '';
            } else 
            {
                $valor_input =  $registro_values[$campo[0]];
            }
            
            if($valor_input != '')
            {
               switch ($class_input) 
                {
                    case 'date':
                        $valor_input = date('Y-m-d', strtotime($valor_input));
                        break;
                    case 'datetime':
                        $valor_input = date('Y-m-d H:i:s', strtotime($valor_input));
                        break;
                } 
            }
            
            if($class_input == 'text')
            {
                $return .= '<textarea '.completarTag($campo[0], $valor_input, $campo[1], $class_input).' '.$tags.' rows="5">'.$valor_input.'</textarea>';
            }else
            {
                $return .= '<input '.completarTag($campo[0], $valor_input, $campo[1], $class_input).' '.$tags.'>';    
            }
                        
            if($required == 1)
            {
                $return .= '<span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>';
                $return .= '</div>';
            }
            
            $return .= '</div>';
         }
         
         $return .= '</div>';     
    }


    $return .= '<div class="row">';
    $return .= '<div class="col-md-6 col-md-offset-3">';
    $return .= '
    <div class="alert alert-danger alert-dismissable divider hide" data-wow-duration="2s" id="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <div id="mensaje_error"></div>
    </div>';
    $return .= '</div>';
    $return .= '</div>';

    $return .= '<div class="form-group">';
    $return .= '<div class="col-md-12 text-center">';
    
    //-- Controla permiso de usuario --
    
    $permiso = 1;
    
    foreach ($session['permisos'] as $key_permisos => $value_permisos) 
    {
        if(strtolower($ci->uri->segment(1).'/table/') == strtolower($value_permisos['url']) )
        {
           $permiso = $value_permisos['editar'];   
        } 
    }
    
    if($permiso == 1){
        //-- AGREGAR REGISTRO --
        if(!$registro)
        {
            $return .= btnAdd();
            
            if($id_table != '')
            {
                $return .= '<input name="'.$id_table.'" id="'.$id_table.'" type="hidden" value="0">'; 
                $return .= btnAdd('permanecer');
            }
            
        //- ACTUALIZAR REGISTRO --
        }else
        {
             $return .= '<input name="'.$id_table.'" id="'.$id_table.'" type="hidden" value="'.$registro_values[$id_table].'">';  
             $return .= btnUpd();
        }    
    }
        
    $return .= '</div>';
    $return .= '</div>';
    
    return $return;
}



function getEffects()
{
    $effects = array(
        // Attention Seekers', 
        'bounce',
        'flash',
        'pulse', 
        //'rubberBand', 
        'shake', 
        'swing', 
        'tada', 
        'wobble', 
        //'jello', 
        
        // Bouncing Entrances', 
        'bounceIn', 
        'bounceInDown', 
        'bounceInLeft', 
        'bounceInRight', 
        'bounceInUp', 
        
        // Bouncing Exits', 
        /*
        'bounceOut', 
        'bounceOutDown', 
        'bounceOutLeft', 
        'bounceOutRight', 
        'bounceOutUp',
        */ 
        
        // Fading Entrances', 
        'fadeIn', 
        'fadeInDown', 
        'fadeInDownBig', 
        'fadeInLeft', 
        'fadeInLeftBig', 
        'fadeInRight', 
        'fadeInRightBig', 
        'fadeInUp', 
        'fadeInUpBig', 
        
        // Fading Exits', 
        /*
        'fadeOut', 
        'fadeOutDown', 
        'fadeOutDownBig', 
        'fadeOutLeft', 
        'fadeOutLeftBig', 
        'fadeOutRight', 
        'fadeOutRightBig', 
        'fadeOutUp', 
        'fadeOutUpBig',
        */ 
        
        // Flippers', 
        //'flip', 
        'flipInX', 
        'flipInY', 
        //'flipOutX', 
        //'flipOutY', 
        
        // Lightspeed', 
        'lightSpeedIn', 
        //lightSpeedOut', 
        
        // Rotating Entrances', 
        'rotateIn', 
        'rotateInDownLeft', 
        'rotateInDownRight', 
        'rotateInUpLeft', 
        'rotateInUpRight', 
        
        // Rotating Exits', 
        /*
        'rotateOut', 
        'rotateOutDownLeft', 
        'rotateOutDownRight', 
        'rotateOutUpLeft', 
        'rotateOutUpRight',
        */  
        
        // Sliding Entrances', 
        'slideInUp', 
        'slideInDown', 
        'slideInLeft', 
        'slideInRight', 

        // Sliding Exits', 
        /*
        'slideOutUp', 
        'slideOutDown', 
        'slideOutLeft', 
        'slideOutRight',
        */ 
        
        // Zoom Entrances', 
        //'zoomIn', 
        //'zoomInDown', 
        //'zoomInLeft',
        //'zoomInRight', 
        //'zoomInUp', 
        
        // Zoom Exits', 
        /*
        'zoomOut', 
        'zoomOutDown', 
        'zoomOutLeft', 
        'zoomOutRight', 
        'zoomOutUp',
        */ 
        
        // Specials', 
        //'hinge', 
        //'rollIn', 
        //'rollOut', 
    );  
    
    return $effects[rand(0, count($effects)-1)];     
}



function getBootstrapSwitch($valor, $id, $function, $set_disabled = 1)
{
    if($set_disabled == 1){
        $disabled = '';
    }else{
        $disabled = 'disabled';
    }
    
    if($valor == 1){
        $return = '<input type="checkbox" id="'.$id.$function.'" onchange="'.$function.'('.$id.')"  class="checkbox" checked '.$disabled.'>';
    } else {
        $return = '<input type="checkbox" id="'.$id.$function.'" onchange="'.$function.'('.$id.')"" class="checkbox" '.$disabled.'>';
    }
    
    return $return;
}
