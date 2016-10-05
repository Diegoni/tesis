<?php
/*--------------------------------------------------------------------------------  
            Comienzo del contenido
 --------------------------------------------------------------------------------*/
 
$cabeceras = array(
    lang('menu'),
    lang('url'),
    lang('opciones'), 
);

$html = startContent();

$html .= '<div id="treeview3" class=""></div>';

if(isset($mensaje)){
    $html .= setMensaje($mensaje);
}

$html .= '<ul class="nav nav-tabs">';
$html .= '<li class="active">';
$html .= '<a  href="#esquema" data-toggle="tab">'.lang('esquema').'</a>';
$html .= '</li>';
$html .= '<li>';
$html .= '<a href="#tabla" data-toggle="tab">'.lang('tabla').'</a>';
$html .= '</li>';
$html .= '</ul>';
$html .= '<br>';

/*--------------------------------------------------------------------------------  
            Esquema
 --------------------------------------------------------------------------------*/

$html .= '<div class="tab-content ">';


$html .= '<div class="tab-pane active" id="esquema">'; 
$html .= tableAdd($subjet);

foreach ($registros as $row) {
    if($row->id_padre == 0){
        $categorias [] = array(
            'id_categoria'  => $row->id_menu,
            'menu'          => $row->menu,
        ); 
         
    }else{
        $menus[$row->id_padre][] = array(
            'id'    => $row->id_menu,
            'menu'  => $row->menu,
        ); 
            
    }
}

foreach ($categorias as $valores) {
    $html .= '<div class="list-group"><ul><li class="permiso" title="'.lang('editar').' '.lang('categoria').'"><a href="'.base_url().'index.php/'.$subjet.'/abm/'.$valores['id_categoria'].'">'.$valores['menu'].'</a>';
    
    if(isset($menus[$valores['id_categoria']])){
        $html .= '<ul>';
        foreach ($menus[$valores['id_categoria']] as $menu) {
            $html .= '<li class="permiso" title="'.lang('editar').' '.lang('menu').'"><a href="'.base_url().'index.php/'.$subjet.'/abm/'.$menu['id'].'">'.$menu['menu'].'</a></li>';           
        }
        $html .= '</ul>';
    }
    
    $html .= '</li></ul> </div>';
}   
   
$html .= '</div>';

/*--------------------------------------------------------------------------------  
            Tabla
 --------------------------------------------------------------------------------*/

$html .= '<div class="tab-pane" id="tabla">'; 

$html .= startTable($cabeceras);

if($registros){
    foreach ($registros as $row) {
        $registro = array(
            $row->menu,
            $row->url,
            tableUpd($subjet, $row->id_menu),
        );
        
        $html .= setTableContent($registro);    
    }
}
            
$html .= endTable($cabeceras);         
$html .= setDatatables();     

$html .= '</div>';

/*--------------------------------------------------------------------------------  
            Fin del contenido
 --------------------------------------------------------------------------------*/
 
$html .= endContent();

echo $html;
?>

<style>
    .permiso{
        margin-top: 10px;
    }
</style>