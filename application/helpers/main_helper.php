<?php

function css_libreria($css){
	$directorio = base_url().'librerias/plantilla/'.$css;
	return '<link rel="stylesheet" href="'.$directorio.'">';
}
 
function js_libreria($js){
	$directorio = base_url().'librerias/plantilla/'.$js;
	return '<script src="'.$directorio.'"></script>';
}

function armar_menu($titulo, $icono, $submenu){
	$menu  = '<li class="treeview">';
	$menu .= '<a href="#">';
	$menu .= '<i class="fa '.$icono.'"></i>';
	$menu .= '<span>'.$titulo.'</span>';
    $menu .= '<i class="fa fa-angle-left pull-right"></i>';
    $menu .= '</a>';
    $menu .= '<ul class="treeview-menu">';
    
	foreach ($submenu as $key => $value) {
		 $menu .= '<li><a href="'.$value.'"><i class="fa fa-circle-o"></i>'.$key.'</a></li>';
	}
	$menu .= '</ul>';
    $menu .= '</li>';
	
	return $menu;
}
