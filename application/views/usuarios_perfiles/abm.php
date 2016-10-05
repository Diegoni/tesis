<?php

$html = setCss('plugins/bootstrap-switch-master/dist/css/bootstrap3/bootstrap-switch.css');
$html .= setJs('plugins/bootstrap-switch-master/dist/js/bootstrap-switch.js');

/*--------------------------------------------------------------------------------  
            Carga de array necesarios
 --------------------------------------------------------------------------------*/ 
    
if($fields){
    foreach ($fields as $field) {
        $registro_values[$field] = '';
    }
}
        
if($registro){
    foreach ($registro as $row) {
        $registro_values = (array) $row;
    }
}

/*--------------------------------------------------------------------------------  
            Comienzo del contenido
 --------------------------------------------------------------------------------*/ 

$html .= startContent();

if(isset($mensaje))
{
    $html .= setMensaje($mensaje);
}

if($registro)
{
    $html .= '<ul class="nav nav-tabs">';
    $html .= '<li class="active">';
    $html .= '<a  href="#1_nav" data-toggle="tab">'.lang('datos').'</a>';
    $html .= '</li>';
    $html .= '<li>';
    $html .= '<a href="#2_nav" data-toggle="tab">'.lang('permisos').'</a>';
    $html .= '</li>';
    $html .= '</ul>';
    $html .= '<br>';
}

/*--------------------------------------------------------------------------------  
            Formulario
 --------------------------------------------------------------------------------*/
 
$html .= '<div class="tab-content ">';
$html .= '<div class="tab-pane active" id="1_nav">';  
 
$html .= '<form action="#" method="post" class="form-horizontal">';
$html .= setForm($campos, $registro_values, $registro, $id_table);
$html .= '</form>';

$html .= '</div>';

/*--------------------------------------------------------------------------------  
            Esquema
 --------------------------------------------------------------------------------*/

$html .= '<div class="tab-pane" id="2_nav">'; 

if($usuarios_permisos)
{
    foreach ($usuarios_permisos as $row) 
    {
        if($row->id_padre == 0)
        {
            $categorias [] = array(
                'id_categoria'      => $row->id_permiso,
                'menu'              => $row->menu,
                'id_permiso'        => $row->id_permiso,
                'ver'               => $row->ver,
                'editar'            => $row->editar,
            ); 
             
        }else
        {
            $menus[$row->id_padre][] = array(
                'id'                => $row->id_permiso,
                'menu'              => $row->menu,
                'id_permiso'        => $row->id_permiso,
                'ver'               => $row->ver,
                'editar'            => $row->editar,
            ); 
                
        }
    }    
}


$registro = array(
    lang('categoria'),
    lang('menu'),
    lang('ver'),
    lang('editar'),
);

$html .= startTable($registro);

foreach ($categorias as $valores) 
{
    $registro = array(
        $valores['menu'],
        '',
        getBootstrapSwitch($valores['ver'], $valores['id_permiso'], 'cambiarPermisoVer', $permiso_editar),
        getBootstrapSwitch($valores['editar'], $valores['id_permiso'],  'cambiarPermisoEditar', $permiso_editar),
    );
    
    $html .= setTableContent($registro);
    
    if(isset($menus[$valores['id_categoria']]))
    {
        foreach ($menus[$valores['id_categoria']] as $menu) 
        {
            $registro = array(
                '',
                $menu['menu'],
                getBootstrapSwitch($menu['ver'], $menu['id_permiso'],  'cambiarPermisoVer', $permiso_editar),
                getBootstrapSwitch($menu['editar'], $menu['id_permiso'], 'cambiarPermisoEditar', $permiso_editar),
            );
            
            $html .= setTableContent($registro);
        }
    }
}  

$html .= endTable();
   
$html .= '</div>';
$html .= '</div>';


/*--------------------------------------------------------------------------------  
            Fin del contenido y js
 --------------------------------------------------------------------------------*/ 
 
$html .= endContent();

echo $html;
?>

<script>
$(".checkbox").bootstrapSwitch();
    
function cambiarPermisoVer(id_rol_permiso)
{
     if($("[id='"+id_rol_permiso+"cambiarPermisoVer']").bootstrapSwitch('state'))
     {
         valor = 1
     }else
     {
         valor = 0;
     }
     
     campo = 'ver';
     
     $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>index.php/Permisos/cambiarPermiso/',
        data: { id_rol_permiso: id_rol_permiso, valor: valor, campo: campo},
        success: function(resp) { 

        }
    });
}



function cambiarPermisoEditar(id_rol_permiso)
{
     if($("[id='"+id_rol_permiso+"cambiarPermisoEditar']").bootstrapSwitch('state'))
     {
         valor = 1
     }else
     {
         valor = 0;
     }
     
     campo = 'editar';
     
     $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>index.php/Permisos/cambiarPermiso/',
        data: { id_rol_permiso: id_rol_permiso, valor: valor, campo: campo},
        success: function(resp) { 

        }
    });
}

</script>